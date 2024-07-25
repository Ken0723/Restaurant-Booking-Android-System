package com.example.fyp;

public class Location {
    private String restaurantID;
    private double x, y;
    public Location(String restaurantID, double x, double y) {
        this.restaurantID = restaurantID;
        this.x = x;
        this.y = y;
    }
    public String getRestaurantID() {
        return restaurantID;
    }
    public double getX() {
        return x;
    }
    public double getY() {
        return y;
    }

    public void setRestaurantID(String restaurantID) {
        this.restaurantID = restaurantID;
    }
    public void setX(double x) {
        this.x = x;
    }
    public void setY(double y) {
        this.y = y;
    }
}
