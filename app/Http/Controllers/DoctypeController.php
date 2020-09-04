<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDoctypeRequest;
use App\Http\Requests\UpdateDoctypeRequest;
use App\Repositories\DoctypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use DB;
use DataTables;

class DoctypeController extends AppBaseController
{
    /** @var  DoctypeRepository */
    private $doctypeRepository;

    public function __construct(DoctypeRepository $doctypeRepo)
    {
        $this->doctypeRepository = $doctypeRepo;
    }

    /**
     * Display a listing of the Doctype.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
      if ($request->ajax()) {

        $data = DB::table('doctypes')->select('doctypes.*')->whereNull('doctypes.deleted_at')->get();

          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('action', function($row){

                    $btn = '<a href="' . route('doctypes.edit', [$row->id]) . '"
                             class="edit btn btn-success btn-sm editProduct" title="Módosítás"><i class="glyphicon glyphicon-edit"></i></a>';

                     $btn = $btn.'<a href="' . route('DTTorles', [$row->id]) . '"
                                   class="btn btn-danger btn-sm deleteProduct" title="Törlés"><i class="glyphicon glyphicon-trash"></i></a>';

                          return $btn;
                  })
                  ->rawColumns(['action'])
                  ->make(true);
      }

      return view('doctypes.index');
    }

    /**
     * Show the form for creating a new Doctype.
     *
     * @return Response
     */
    public function create()
    {
        return view('doctypes.create');
    }

    /**
     * Store a newly created Doctype in storage.
     *
     * @param CreateDoctypeRequest $request
     *
     * @return Response
     */
    public function store(CreateDoctypeRequest $request)
    {
        $input = $request->all();

        $doctype = $this->doctypeRepository->create($input);

        return redirect(route('doctypes.index'));
    }

    /**
     * Display the specified Doctype.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $doctype = $this->doctypeRepository->find($id);

        if (empty($doctype)) {
            Flash::error('Nem található tétel!');

            return redirect(route('doctypes.index'));
        }

        return view('doctypes.show')->with('doctype', $doctype);
    }

    /**
     * Show the form for editing the specified Doctype.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $doctype = $this->doctypeRepository->find($id);

        if (empty($doctype)) {
            Flash::error('Nem található tétel!');

            return redirect(route('doctypes.index'));
        }

        return view('doctypes.edit')->with('doctype', $doctype);
    }

    /**
     * Update the specified Doctype in storage.
     *
     * @param int $id
     * @param UpdateDoctypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDoctypeRequest $request)
    {
        $doctype = $this->doctypeRepository->find($id);

        if (empty($doctype)) {
            Flash::error('Nem található tétel!');

            return redirect(route('doctypes.index'));
        }

        $doctype = $this->doctypeRepository->update($request->all(), $id);

        return redirect(route('doctypes.index'));
    }

    /**
     * Remove the specified Doctype from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $doctype = $this->doctypeRepository->find($id);

        if (empty($doctype)) {
            Flash::error('Nem található tétel!');

            return redirect(route('doctypes.index'));
        }

        $this->doctypeRepository->delete($id);

        return redirect(route('doctypes.index'));
    }

    public function destroyMe($id)
    {
      $doctype = $this->doctypeRepository->find($id);
      if (empty($doctype)) {
          Flash::error('Nem található tétel!');

          return redirect(route('doctypes.index'));
      }

      $this->doctypeRepository->delete($id);
      return redirect(route('doctypes.index'));
    }
}
