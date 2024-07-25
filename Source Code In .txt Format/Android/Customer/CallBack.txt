package com.example.fyp;

import java.util.ArrayList;

interface GetUserCallBack {
    public abstract void done(Customer returnedCustomer);
}
interface RegisterCallBack {
    public abstract  void done(boolean returnedBoolean);
}
interface GetTableCallBack {
    public abstract  void done(ArrayList tableArray);
}
interface GetReservationCallBack {
    public abstract void done (ArrayList reservationArray);
}
interface GetBookingCallBack {
    public abstract void done(boolean isSuccess);
}
interface GetUpdateCallBack {
    public abstract void done(boolean isSuccess);
}
interface CancelReservationCallBack {
    public abstract void done(boolean isSuccess);
}
interface GetNewsCallBack {
    public abstract void done(ArrayList newsArray);
}
interface GetAllFoodCallBack {
    public abstract void done(ArrayList foodArray);
}
interface GetOwnReservationCallBack {
    public abstract void done(Reservation reservation);
}
interface GetStartingReservationCallBack {
    public abstract void done(Reservation reservation);
}
interface StartReservationCallBack {
    public abstract void done(Boolean isSuccess);
}
interface OrderFoodCallBack {
    public abstract void done(Boolean isSuccess);
}
interface CallWaiterCallBack {
    public abstract void done(Boolean isSuccess);
}
interface GetAllOrderIDCallBack {
    public abstract void done(ArrayList<Order> orderArrayList);
}
interface GetOrderedFoodCallBack {
    public abstract void done(ArrayList<OrderFood> orderedFoodArrayList);
}
interface GetRestaurantLocationCallBack {
    public abstract void done(Location location);
}
interface PaymentCallBack {
    public abstract void done(Boolean isSuccess);
}

