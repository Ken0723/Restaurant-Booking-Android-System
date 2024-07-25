package com.example.fyp;

public class Reservation {

    String reservationID, restaurantID, customerID, tableID, date, time, status;

    public Reservation() {
        reservationID = "";
        restaurantID = "";
        customerID = "";
        tableID = "";
        date = "";
        time = "";
        status = "";
    }
    public Reservation(String reserID, String resID, String cusID, String tableID, String date, String time, String status) {
        this.reservationID = reserID;
        this.restaurantID = resID;
        this.customerID = cusID;
        this.tableID = tableID;
        this.date = date;
        this.time = time;
        this.status = status;
    }
    public String getReservationID() {
        return reservationID;
    }
    public String getRestaurantID() {
        return restaurantID;
    }
    public String getCustomerID() {
        return customerID;
    }
    public String getTableID() {
        return tableID;
    }
    public String getDate() {
        return date;
    }
    public String getTime() { return time; }
    public String getStatus() {
        return status;
    }
    public void setReservationID(String sReserID) {
        this.reservationID = sReserID;
    }
    public void setRestaurantID(String sResID) {
        this.restaurantID = sResID;
    }
    public void setCustomerID(String sCusID) {
        this.customerID = sCusID;
    }
    public void setTableID(String sTableID) {
        this.tableID = sTableID;
    }
    public void setDate(String sDate) {
        this.date = sDate;
    }
    public void setTime(String sTime) { this.time = sTime; }
    public void setStatus(String sStatus) {
        this.status = sStatus;
    }
}
