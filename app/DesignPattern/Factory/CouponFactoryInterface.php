<?php

namespace App\DesignPattern\Factory;

use App\Models\Coupon;


interface CouponFactoryInterface {
       public function getAddCouponPage();
    public function createCoupon(array $data): Coupon;
    public function updateCoupon(int $couponId, array $data): Coupon;
    public function activateCoupon(int $couponId): Coupon;
    public function deactivateCoupon(int $couponId): Coupon;
    public function deleteCoupon(int $couponId): void;
    public function getAllCoupons();
}
