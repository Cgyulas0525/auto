<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCostRequest;
use App\Http\Requests\UpdateCostRequest;
use App\Repositories\CostRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use DB;
use DataTables;

class CostController extends AppBaseController
{
    /** @var  CostRepository */
    private $costRepository;

    public function __construct(CostRepository $costRepo)
    {
        $this->costRepository = $costRepo;
    }

    /**
     * Display a listing of the Cost.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
      if ($request->ajax()) {

        $data = DB::table('costs')->select('costs.*')->whereNull('costs.deleted_at')->get();

          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('action', function($row){

                    $btn = '<a href="' . route('costs.edit', [$row->id]) . '"
                             class="edit btn btn-success btn-sm editProduct" title="Módosítás"><i class="glyphicon glyphicon-edit"></i></a>';

                     $btn = $btn.'<a href="' . route('KTTorles', [$row->id]) . '"
                                   class="btn btn-danger btn-sm deleteProduct" title="Törlés"><i class="glyphicon glyphicon-trash"></i></a>';

                          return $btn;
                  })
                  ->rawColumns(['action'])
                  ->make(true);
      }

      return view('costs.index');
    }

    /**
     * Show the form for creating a new Cost.
     *
     * @return Response
     */
    public function create()
    {
        return view('costs.create');
    }

    /**
     * Store a newly created Cost in storage.
     *
     * @param CreateCostRequest $request
     *
     * @return Response
     */
    public function store(CreateCostRequest $request)
    {
        $input = $request->all();

        $cost = $this->costRepository->create($input);

        return redirect(route('costs.index'));
    }

    /**
     * Display the specified Cost.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cost = $this->costRepository->find($id);

        if (empty($cost)) {
            Flash::error('Nem található tétel!');

            return redirect(route('costs.index'));
        }

        return view('costs.show')->with('cost', $cost);
    }

    /**
     * Show the form for editing the specified Cost.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cost = $this->costRepository->find($id);

        if (empty($cost)) {
            Flash::error('Nem található tétel!');

            return redirect(route('costs.index'));
        }

        return view('costs.edit')->with('cost', $cost);
    }

    /**
     * Update the specified Cost in storage.
     *
     * @param int $id
     * @param UpdateCostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCostRequest $request)
    {
        $cost = $this->costRepository->find($id);

        if (empty($cost)) {
            Flash::error('Nem található tétel!');

            return redirect(route('costs.index'));
        }

        $cost = $this->costRepository->update($request->all(), $id);

        return redirect(route('costs.index'));
    }

    /**
     * Remove the specified Cost from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cost = $this->costRepository->find($id);

        if (empty($cost)) {
            Flash::error('Nem található tétel!');

            return redirect(route('costs.index'));
        }

        $this->costRepository->delete($id);

        return redirect(route('costs.index'));
    }

    public function destroyMe($id)
    {
      $cost = $this->costRepository->find($id);
      if (empty($cost)) {
          Flash::error('Nem található tétel!');

          return redirect(route('costs.index'));
      }

      $this->costRepository->delete($id);
      return redirect(route('costs.index'));
    }
}
