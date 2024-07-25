package com.example.fyp;

public class Food {
    private String code, name, category, description;
    private double price;

    public Food(String code, String name, String category, double price, String description) {
        this.code = code;
        this.name = name;
        this.category = category;
        this.price = price;
        this.description = description;
    }
    public String getCode() {
        return code;
    }
    public String getName() {
        return name;
    }
    public String getCategory() {
        return category;
    }
    public double getPrice() {
        return price;
    }
    public String getDescription() {
        return description;
    }
    public void setCode(String nCode) {
        this.code = nCode;
    }
    public void setName(String nName) {
        this.name = nName;
    }
    public void setCategory(String nCategory) {
        this.category = nCategory;
    }
    public void setPrice(double nPrice) {
        this.price = price;
    }
    public void setDescription(String nDescription) {
        this.description = nDescription;
    }
}
