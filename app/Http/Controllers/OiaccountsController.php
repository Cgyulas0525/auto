<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIoaccountsRequest;
use App\Http\Requests\UpdateIoaccountsRequest;
use App\Repositories\IoaccountsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use DB;
use DataTables;

class OiaccountsController extends AppBaseController
{
    /** @var  IoaccountsRepository */
    private $ioaccountsRepository;

    public function __construct(IoaccountsRepository $ioaccountsRepo)
    {
        $this->ioaccountsRepository = $ioaccountsRepo;
    }

    /**
     * Display a listing of the Ioaccounts.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
      if ($request->ajax()) {

        $data = DB::table('ioaccounts')
                    ->join('partners AS p1', 'p1.id', 'ioaccounts.partner' )
                    ->join('costs AS p3', 'p3.id', 'ioaccounts.tipus')
                    ->select('ioaccounts.*', 'p1.nev as partner_nev', 'p3.nev as ktg_nev')
                    ->whereNull('ioaccounts.deleted_at')
                    ->where('ioaccounts.io', '=', '2')
                    ->get();

          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('action', function($row){

                    $btn = '<a href="' . route('oiaccounts.edit', [$row->id]) . '"
                             class="edit btn btn-success btn-sm editProduct" title="Módosítás"><i class="glyphicon glyphicon-edit"></i></a>';

                     $btn = $btn.'<a href="' . route('OiSzamlaTorles', [$row->id]) . '"
                                   class="btn btn-danger btn-sm deleteProduct" title="Törlés"><i class="glyphicon glyphicon-trash"></i></a>';

                          return $btn;
                  })
                  ->rawColumns(['action'])
                  ->make(true);
      }

      return view('oiaccounts.index');
    }

    /**
     * Show the form for creating a new Ioaccounts.
     *
     * @return Response
     */
    public function create()
    {
        return view('oiaccounts.create');
    }

    /**
     * Store a newly created Ioaccounts in storage.
     *
     * @param CreateIoaccountsRequest $request
     *
     * @return Response
     */
    public function store(CreateIoaccountsRequest $request)
    {
        $input = $request->all();
        $input['io'] = 2;
        $ioaccounts = $this->ioaccountsRepository->create($input);
        return redirect(route('oiaccounts.index'));
    }

    /**
     * Display the specified Ioaccounts.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ioaccounts = $this->ioaccountsRepository->find($id);

        if (empty($ioaccounts)) {
            Flash::error('Ioaccounts not found');

            return redirect(route('oiaccounts.index'));
        }

        return view('oiaccounts.show')->with('ioaccounts', $ioaccounts);
    }

    /**
     * Show the form for editing the specified Ioaccounts.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ioaccounts = $this->ioaccountsRepository->find($id);

        if (empty($ioaccounts)) {
            Flash::error('Ioaccounts not found');

            return redirect(route('oiaccounts.index'));
        }

        return view('oiaccounts.edit')->with('ioaccounts', $ioaccounts);
    }

    /**
     * Update the specified Ioaccounts in storage.
     *
     * @param int $id
     * @param UpdateIoaccountsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIoaccountsRequest $request)
    {
        $ioaccounts = $this->ioaccountsRepository->find($id);

        if (empty($ioaccounts)) {
            Flash::error('Ioaccounts not found');

            return redirect(route('oiaccounts.index'));
        }

        $ioaccounts = $this->ioaccountsRepository->update($request->all(), $id);
        return redirect(route('oiaccounts.index'));
    }

    /**
     * Remove the specified Ioaccounts from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ioaccounts = $this->ioaccountsRepository->find($id);

        if (empty($ioaccounts)) {
            Flash::error('Ioaccounts not found');

            return redirect(route('oiaccounts.index'));
        }

        $this->ioaccountsRepository->delete($id);
        return redirect(route('oiaccounts.index'));
    }

    public function destroyMe($id)
    {
      $account = $this->accountRepository->find($id);
      if (empty($account)) {
          Flash::error('Nem található tétel!');

          return redirect(route('oiaccounts.index'));
      }

      $this->accountRepository->delete($id);
      return redirect(route('oiaccounts.index'));
    }

}
