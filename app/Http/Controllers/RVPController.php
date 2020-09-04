<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Repositories\AccountRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use DB;
use DataTables;
use App\Classes\SendMail;


class RVPController extends AppBaseController
{
    /** @var  AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepository = $accountRepo;
    }

    /**
     * Display a listing of the Account.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
      if ($request->ajax()) {

        $data = DB::table('accounts')
                    ->join('partners AS p1', 'p1.id', 'accounts.partner' )
                    ->join('cars AS p2', 'p2.id', 'accounts.auto' )
                    ->join('costs AS p3', 'p3.id', 'accounts.tipus')
                    ->select('accounts.*', 'p1.nev as partner_nev', 'p2.rendszam as auto', 'p3.nev as ktg_nev')
                    ->where('accounts.auto', '=', '3')
                    ->whereNull('accounts.deleted_at')
                    ->get();

          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('action', function($row){

                    $btn = '<a href="' . route('rvp.edit', [$row->id]) . '"
                             class="edit btn btn-success btn-sm editProduct" title="Módosítás"><i class="glyphicon glyphicon-edit"></i></a>';

                     $btn = $btn.'<a href="' . route('RVPTorles', [$row->id]) . '"
                                   class="btn btn-danger btn-sm deleteProduct" title="Törlés"><i class="glyphicon glyphicon-trash"></i></a>';

                          return $btn;
                  })
                  ->rawColumns(['action'])
                  ->make(true);
      }

      return view('rvp.index');
    }

    /**
     * Show the form for creating a new Account.
     *
     * @return Response
     */
    public function create()
    {
        return view('rvp.create');
    }

    /**
     * Store a newly created Account in storage.
     *
     * @param CreateAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountRequest $request)
    {
        $input = $request->all();

        $account = $this->accountRepository->create($input);
        SendMail::AccountMail($account);
        return redirect(route('rvp.index'));
    }

    /**
     * Display the specified Account.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $account = $this->accountRepository->find($id);

        if (empty($account)) {
            return redirect(route('rvp.index'));
        }

        return view('rvp.show')->with('account', $account);
    }

    /**
     * Show the form for editing the specified Account.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $account = $this->accountRepository->find($id);

        if (empty($account)) {
            Flash::error('Nem található tétel!');

            return redirect(route('rvp.index'));
        }

        return view('rvp.edit')->with('account', $account);
    }

    /**
     * Update the specified Account in storage.
     *
     * @param int $id
     * @param UpdateAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountRequest $request)
    {
        $account = $this->accountRepository->find($id);

        if (empty($account)) {
            Flash::error('Nem található tétel!');

            return redirect(route('rvp.index'));
        }

        $account = $this->accountRepository->update($request->all(), $id);
        return redirect(route('rvp.index'));
    }

    /**
     * Remove the specified Account from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $account = $this->accountRepository->find($id);

        if (empty($account)) {
            Flash::error('Nem található tétel!');

            return redirect(route('rvp.index'));
        }

        $this->accountRepository->delete($id);
        return redirect(route('rvp.index'));
    }

    public function destroyMe($id)
    {
      $account = $this->accountRepository->find($id);
      if (empty($account)) {
          Flash::error('Nem található tétel!');

          return redirect(route('rvp.index'));
      }

      $this->accountRepository->delete($id);
      return redirect(route('rvp.index'));
    }
}
