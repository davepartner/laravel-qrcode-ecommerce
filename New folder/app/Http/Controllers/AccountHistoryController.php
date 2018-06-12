<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountHistoryRequest;
use App\Http\Requests\UpdateAccountHistoryRequest;
use App\Repositories\AccountHistoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AccountHistoryController extends AppBaseController
{
    /** @var  AccountHistoryRepository */
    private $accountHistoryRepository;

    public function __construct(AccountHistoryRepository $accountHistoryRepo)
    {
        $this->accountHistoryRepository = $accountHistoryRepo;
    }

    /**
     * Display a listing of the AccountHistory.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->accountHistoryRepository->pushCriteria(new RequestCriteria($request));
        $accountHistories = $this->accountHistoryRepository->all();

        return view('account_histories.index')
            ->with('accountHistories', $accountHistories);
    }

    /**
     * Show the form for creating a new AccountHistory.
     *
     * @return Response
     */
    public function create()
    {
        return view('account_histories.create');
    }

    /**
     * Store a newly created AccountHistory in storage.
     *
     * @param CreateAccountHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountHistoryRequest $request)
    {
        $input = $request->all();

        $accountHistory = $this->accountHistoryRepository->create($input);

        Flash::success('Account History saved successfully.');

        return redirect(route('accountHistories.index'));
    }

    /**
     * Display the specified AccountHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        return view('account_histories.show')->with('accountHistory', $accountHistory);
    }

    /**
     * Show the form for editing the specified AccountHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        return view('account_histories.edit')->with('accountHistory', $accountHistory);
    }

    /**
     * Update the specified AccountHistory in storage.
     *
     * @param  int              $id
     * @param UpdateAccountHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountHistoryRequest $request)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        $accountHistory = $this->accountHistoryRepository->update($request->all(), $id);

        Flash::success('Account History updated successfully.');

        return redirect(route('accountHistories.index'));
    }

    /**
     * Remove the specified AccountHistory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        $this->accountHistoryRepository->delete($id);

        Flash::success('Account History deleted successfully.');

        return redirect(route('accountHistories.index'));
    }
}
