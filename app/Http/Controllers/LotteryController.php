<?php
/**
 * Created by PhpStorm.
 * User: Landan
 * Date: 2018/9/27
 * Time: 20:43
 * Controller is relative to RESTful API， thus th
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use core\controller\CoreController;
use App\Models\LotteryModel;

class LotteryController extends CoreController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * @param Request $oRequest
     */
    public function getShow(Request $oRequest) {

        try {
            $iId = null;
            $aQueries = [];
            $aOptions = [];

            if ($oRequest->input('id')) {
                $iId = $oRequest->input('id');
            }

            if ($oRequest->input('type')) {
                $aQueries['type'] = $oRequest->input('type');
            }

            if ($oRequest->input('high_frequentcy')) {
                $aQueries['high_frequentcy'] = $oRequest->input('high_frequentcy');
            }

            $aOptions['offset'] = $this->offset;
            if ($oRequest->input('offset')) {
                $aOptions['offset'] = $oRequest->input('offset');
            }

            $aOptions['limit'] = $this->limit;
            if ($oRequest->input('limit')) {
                $aOptions['limit'] = $oRequest->input('limit');
            }

            $oLotteryModel = new LotteryModel();

            $aLotteries = $oLotteryModel->show($iId, $aQueries, $aOptions);
            $iTotalCount = $oLotteryModel->num($iId, $aQueries);

            if (null === $aLotteries) {
                throw new \Exception('IT_FAILS_TO_SHOW_LOTTERY');
            };


            $aData = [
                'lotteries' => $aLotteries
            ];

            $oRequest->request->add(['message' => 'IT_SUCCEEDS_TO_SHOW_LOTTERY']);
            $oRequest->request->add(['data' => $aData]);
            $oRequest->request->add(['total_count' => $iTotalCount]);
            $oRequest->request->add(['jwt' => '']);

        } catch (\Exception $oError){
            $sMessage = $oError->getMessage();
            $oRequest->request->add(['message' => $sMessage]);

        } finally {

        }

    }

    public function postAdd($request) {

    }

    public function putEdit($request) {

    }

    public function deleteRemove($request) {

    }
}
