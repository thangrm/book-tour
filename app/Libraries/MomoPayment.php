<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MomoPayment
{
    public static function purchase(array $options = [])
    {
        $accessKey = env('MOMO_ACCESS_KEY');
        $partnerCode = env('MOMO_PARTNER_CODE');
        $secretKey = env('MOMO_SECRET_KEY');

        $ipnUrl = $options['ipnUrl'] ?? null;
        $redirectUrl = $options['redirectUrl'] ?? null;
        $orderId = $options['orderId'] ?? null;
        $amount = $options['amount'] ?? null;
        $orderInfo = $options['orderInfo'] ?? null;
        $requestId = $options['requestId'] ?? null;
        $extraData = $options['extraData'] ?? "";

        $endPoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
        $rawHash = "partnerCode=$partnerCode&accessKey=$accessKey&requestId=$requestId&amount=$amount&orderId=$orderId&orderInfo=$orderInfo&returnUrl=$redirectUrl&notifyUrl=$ipnUrl&extraData=$extraData";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $requestType = "captureMoMoWallet";

        return Http::post($endPoint, [
            'accessKey' => $accessKey,
            'partnerCode' => $partnerCode,
            'partnerName' => 'Công ty du lịch Thắng Lợi',
            'requestType' => $requestType,
            'notifyUrl' => $ipnUrl,
            'returnUrl' => $redirectUrl,
            'orderId' => $orderId,
            'amount' => $amount,
            'orderInfo' => $orderInfo,
            'requestId' => $requestId,
            'extraData' => $extraData,
            'signature' => $signature,
        ]);
    }

    public static function completePurchase(Request $request)
    {
        $accessKey = env('MOMO_ACCESS_KEY');
        $partnerCode = env('MOMO_PARTNER_CODE');
        $secretKey = env('MOMO_SECRET_KEY');

        $orderId = $request->orderId;
        $localMessage = $request->localMessage;
        $message = $request->message;
        $transId = $request->transId;
        $orderInfo = $request->orderInfo;
        $amount = $request->amount;
        $errorCode = $request->errorCode;
        $responseTime = $request->responseTime;
        $requestId = $request->requestId;
        $payType = $request->payType;
        $orderType = $request->orderType;
        $extraData = $request->extraData;
        $m2signature = $request->signature;

        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
            "&payType=" . $payType . "&extraData=" . $extraData;

        $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

        $success = false;
        if ($m2signature == $partnerSignature) {
            if ($errorCode == '0') {
                $resultMessage = array('Thanh toán thành công');
                $success = true;
            } else {
                $resultMessage = $localMessage;
            }
        } else {
            $resultMessage = 'Chữ ký không hợp lệ';
        }
        return array('success' => $success, 'message' => $resultMessage);
    }
}

