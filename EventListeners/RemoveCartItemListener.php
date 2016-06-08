<?php
/*************************************************************************************/
/*      This file is part of the CouponOfferedProduct package.                       */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace CouponOfferedProduct\EventListeners;

use CouponOfferedProduct\CouponOfferedProduct;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;

class RemoveCartItemListener implements EventSubscriberInterface
{
    /** @var  Request */
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::CART_DELETEITEM => array('removeCouponFromSession', 300)
        );
    }

    public function removeCouponFromSession()
    {
        $consumedCoupons = $this->request->getSession()->getConsumedCoupons();

        if (!isset($consumedCoupons) || !$consumedCoupons) {
            $consumedCoupons = array();
        }

        foreach ($consumedCoupons as $key => $value) {
            if (CouponOfferedProduct::isCouponTypeOfferedProduct($value)) {
                unset($consumedCoupons[$key]);
            }
        }

        $this->request->getSession()->setConsumedCoupons($consumedCoupons);
    }
}