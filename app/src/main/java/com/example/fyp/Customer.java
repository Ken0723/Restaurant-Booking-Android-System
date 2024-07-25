package com.example.fyp;

public class Customer {
    String accID, firstName, lastName, email, password, phone, address;

    public Customer() {
        this.firstName = "";
        this.lastName = "";
        this.accID = "";
        this.email = "";
        this.password = "";
        this.phone = "";
        this.address = "";
    }
    public Customer(String email, String password) {
        this.firstName = "";
        this.lastName = "";
        this.accID = "";
        this.email = email;
        this.password = password;
        this.phone = "";
        this.address = "";
    }

    public Customer(String accID, String firstName, String lastName, String email, String password, String phone, String address) {
        this.accID = accID;
        this.firstName = firstName;
        this.lastName = lastName;
        this.email = email;
        this.password = password;
        this.phone = phone;
        this.address = address;
    }
    public String getAccID() {return this.accID;}
    public String getFirstName() {
        return this.firstName;
    }
    public String getLastName() {
        return this.lastName;
    }
    public String getEmail() {
        return this.email;
    }
    public String getPassword() {
        return this.password;
    }
    public String getPhone() { return  this.phone; }
    public String getAddress() { return this.address; }

    public void setAccID(String id) { accID = id;}
    public void setFirstName(String sName) {
        firstName = sName;
    }
    public void setLastName(String sName) {
        lastName = sName;
    }
    public void setEmail(String sEmail) {
        email = sEmail;
    }
    public void setPassword(String sPassword) {
        password = sPassword;
    }
    public void setPhone(String sPhone) { phone = sPhone; }
    public void setAddress(String sAddress) { address = sAddress; }
}
