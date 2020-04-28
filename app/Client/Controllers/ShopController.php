<?php

namespace Client\Controllers;

use Admin\Repositories\CounterRepository;
use Carbon\Carbon;
use Client\Repositories\ProductRepository;
use Client\Controllers\Shared\SiteController;
use Shared\Core\Controllers\IProtected;
use Shared\Core\DotEnv;
use Shared\Core\Http\Request;
use Shared\Core\App;
use Client\Repositories\BillRepository;
use Client\Repositories\PurchaseRepository;
use Client\Repositories\UserRepository\UserRepository;
use Client\Services\ActionService\Action;
use Client\Services\ActionService\IAction;
use Client\Services\AuthService;
use Client\Services\CommandService\Command;
use Client\Services\NotificationService\NotificationService;

class ShopController extends SiteController implements IProtected
{
    public function getProtectedMethods()
    {
        return ['main', 'buy', 'putMoney'];
    }

    public function main()
    {
        /** @var AuthService $authService */
        $authService = App::get('authService');
        $user = $authService->getUser();

        /** @var ProductRepository $productRepository */
        $productRepository = App::get('product');

//        $groupsWithProducts = [
//            [
//                'name' => '💬 Премиум',
//                'about' => "Для общения с новыми девушками необходимо оплачивать премиум-аккаунт.
//Без премиум аккаунта ваша анкета остаётся в поиске, вы можете получать сообщения, но отвечать не сможете, также контактная информация на вашей странице будет скрыта.
//Эта услуга в том числе и для вашего удобства. Мы отсекаем праздных посетителей и спамеров.",
//                'products' => [
//                    [
//                        'id' => 1,
//                        'name' => '3 дня',
//                        'price' => 990,
//                        'about' => ''
//                    ],
//                    [
//                        'id' => 2,
//                        'name' => '2 недели',
//                        'price' => 2690,
//                        'about' => ''
//                    ],
//                    [
//                        'id' => 3,
//                        'name' => '30 дней',
//                        'price' => 4530,
//                        'about' => ''
//                    ],
//                ]
//            ],
//            [
//                'name' => '🕶️ Невидимка',
//                'about' => "Вы можете скрыть свое присутствие на сайте, для всех будет выглядеть, что вы на сайт не заходите.
//Как работает функция. Прочитайте, пожалуйста.
//При включении режима «Инкогнито» для всех посетителей вашей анкеты и собеседников временем последнего вашего посещения будет показываться момент включения этой функции.
//Вы не будете отображаться в «Кто смотрел?» у пользователей. Но имейте ввиду –если вы отвечаете на рассылку или создаете ее – дата последнего будет показываться «Инкогнито», поэтому для тех кто смотрит рассылку или ваши ответы на нее - вы можете «попасться».
//Если вы во время действия будете общаться с кем-либо, именно для этого собеседника датой последнего посещения будет дата вашего последнего сообщения ему.
//Т.е. последнее ваше посещение для всех, с кем вы не общались – момент включения режима «Инкогнито», для тех, с кем общались после включения – дата вашего последнего сообщения.
//Это сделано чтобы не выдать активный режим «Инкогнито», иначе будет видно, что дата вашего последнего посещения – фальшивая.",
//                'products' => [
//                    [
//                        'id' => 4,
//                        'name' => '30 дней',
//                        'price' => 690,
//                        'about' => ''
//                    ],
//                ]
//            ],
//            [
//                'name' => '📌 ТОП',
//                'about' => "При закреплении в ТОП ваша анкета будет всегда вверху поиска.",
//                'products' => [
//                    [
//                        'id' => 5,
//                        'name' => '2 недели',
//                        'price' => 290,
//                        'about' => ''
//                    ],
//                    [
//                        'id' => 6,
//                        'name' => '30 дней',
//                        'price' => 490,
//                        'about' => ''
//                    ],
//                ]
//            ],
//            [
//                'name' => '⬆️ Поднятие анкеты',
//                'about' => "Поднятие сделает вашу анкету в поиске первой после анкет из раздела \"ТОП\".
//Также поднятие анкеты сделает вашу анкету в категории \"ТОП\" первой, если вы уже оплатили \"ТОП\"",
//                'products' => [
//                    [
//                        'id' => 7,
//                        'name' => 'Разовое поднятие анкеты',
//                        'price' => 190,
//                        'about' => ''
//                    ],
//                ]
//            ],
//        ];

        $boughtProducts = $productRepository->getUserProducts($user['id']);

        foreach ($boughtProducts as &$boughtProduct) {
            $boughtProduct['createdAt'] = Carbon::parse($boughtProduct['createdAt'])
                ->locale('ru')->isoFormat('D MMMM YYYY, HH:mm');
            $boughtProduct['expiredAt'] = Carbon::parse($boughtProduct['expiredAt'])
                ->locale('ru')->isoFormat('D MMMM YYYY, HH:mm');
        }

        $groups = $productRepository->getProductGroups();

        foreach ($groups as &$group) {
            $group['products'] = $productRepository->getProductsByGroup($group['id']);
        }

        /** @var CounterRepository $counterRepository */
        $counterRepository = App::get('counter');

        return $this->render([
            'groupsWithProducts' => $groups,
            'boughtProducts' => $boughtProducts,
            'counters' => $counterRepository->getUserCounters($user['id']),
        ]);
    }

    public function buy(Request $request, int $productId)
    {
        /** @var AuthService $authService */
        $authService = App::get('authService');
        $user = $authService->getUser();

        /** @var ProductRepository $productRepository */
        $productRepository = App::get('product');
        $product = $productRepository->product($productId);

        if ($product === null) {
            /** @var NotificationService $notificationService */
            $notificationService = App::get('notificationService');
            $notificationService->set('error', 'Пожалусйта попробуйте позже.');
            $request->redirect('/shop');
        }

        if ($user['money'] < $product['price']) {
            /** @var NotificationService $notificationService */
            $notificationService = App::get('notificationService');
            $notificationService->set('error', 'Недостаточно денег на счете. Пожалусйта пополните счет и повторите.');
            $request->redirect('/shop');
        }

        /** @var UserRepository $userRepository */
        $userRepository = App::get('user');
        $userRepository->reduceMoney($user['id'], $product['price']);

        $activeProduct = $productRepository->getActiveUserProductByGroup($user['id'], $product['groupId']);
        $carbonStartExpiredAt = $activeProduct === null
            ? Carbon::now()
            : Carbon::parse($activeProduct['expiredAt'])
        ;

        $createdAt = Carbon::now()->toDateTimeString();
        $expiredAt = $carbonStartExpiredAt->addHours($product['duration'])->toDateTimeString();

        $productRepository->addProductToUser($productId, $user['id'], $createdAt, $expiredAt);

        /** @var PurchaseRepository $purchaseRepository */
        $purchaseRepository = App::get('purchase');
        $purchaseRepository->create($user['id'], $productId, $product['price']);

        foreach ($productRepository->getProductCommands($productId) as $command) {
            /** @var Command $commandObject */
            $commandObject = App::get('command');
            $commandName = $command['name'];

            if (method_exists($commandObject, $commandName)) {
                $commandObject->$commandName($user['id']);
            }
        }

        $request->redirect('/shop');
    }

    public function putMoney(Request $request)
    {
        /** @var AuthService $authService */
        $authService = App::get('authService');
        $user = $authService->getUser();
        $amount = $request->post('amount');

        if (empty($amount) || $amount < 1) {
            /** @var NotificationService $notificationService */
            $notificationService = App::get('notificationService');
            $notificationService->set('error', 'Сумма должна быть больше 1 руб');
            $request->redirect('/shop');
        }

        /** @var BillRepository $billRepository */
        $billRepository = App::get('bill');
        $billId = $billRepository->create($amount, $user['id']);

        /** @var DotEnv $dotEnv */
        $dotEnv = App::get('env');
        $billPayments = new \Qiwi\Api\BillPayments($dotEnv->get('QIWI_SECRET_KEY'));

        $params = [
            'publicKey' => $dotEnv->get('QIWI_PUBLIC_KEY'),
            'amount' => $amount,
            'billId' => $billId,
            'successUrl' => 'http://ankira.local/shop',
        ];

        /** @var \Qiwi\Api\BillPayments $billPayments */
        $request->redirect($billPayments->createPaymentForm($params), 'external');
    }

    public function successPutMoneyCallback(Request $request)
    {
        $data = $request->decodedJson('bill');

        $headers = getallheaders();
        $hmacHash = $headers['X-Api-Signature-SHA256'];

        if (!is_object($data) || empty($hmacHash)) {
            $this->renderJson([
                'status' => 'FAIL',
                'error' => true,
                'errorText' => 'Forbidden',
            ]);
        }

        $invoiceParameters = "{$data->amount->currency}|{$data->amount->value}|{$data->billId}|{$data->siteId}|{$data->status->value}";

        /** @var DotEnv $dotEnv */
        $dotEnv = App::get('env');
        $hash = hash_hmac('sha256', $invoiceParameters, $dotEnv->get('QIWI_SECRET_KEY'));

        if ($hash !== $hmacHash) {
            $this->renderJson([
                'status' => 'FAIL',
                'error' => true,
                'errorText' => 'Forbidden',
            ]);
        }

        /** @var BillRepository $billRepository */
        $billRepository = App::get('bill');

        if ($billRepository->getOne((int) $data->billId)['paidAt'] !== null) {
            $this->renderJson([
                'status' => 'FAIL',
                'error' => true,
                'errorText' => 'Bill already processed',
            ]);
        }

        $billRepository->setPaid((int) $data->billId, str_replace('T', ' ', $data->status->datetime));
        $userId = $billRepository->getUserId((int) $data->billId);

        /** @var UserRepository $userRepository */
        $userRepository = App::get('user');
        $userRepository->increaseMoney($userId, (float) $data->amount->value);
        Action::run(IAction::PUT_MONEY, $userId);

        $this->renderJson([
            'status' => 'OK',
            'error' => false,
            'errorText' => '',
        ]);
    }
}