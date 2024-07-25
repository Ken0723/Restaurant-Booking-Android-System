package com.example.fyp;

public class OrderFood {

    private String orderID, foodItemCode, qty;

    public OrderFood(String orderID, String foodItemCode, String qty) {
        this.orderID = orderID;
        this.foodItemCode = foodItemCode;
        this.qty = qty;
    }
    public String getOrderID() {
        return orderID;
    }
    public String getFoodItemCode() {
        return foodItemCode;
    }
    public String getQty() {
        return qty;
    }
    public void setOrderID(String nOrderID) {
        this.orderID = nOrderID;
    }
    public void setFoodItemCode(String nFoodItemCode) {
        this.foodItemCode = nFoodItemCode;
    }
    public void setQty(String nQty) {
        this.qty = nQty;
    }
}
