package com.example.fyp;

public class News_Bean {

    private String id, title, description;

    public News_Bean(String id, String title, String description) {
        this.id = id;
        this.title = title;
        this.description = description;
    }
    public String getId() {
        return id;
    }
    public String getTitle() {
        return title;
    }
    public String getDescription() {
        return description;
    }
    public void setId(String nid) {
        this.id = nid;
    }
    public void setTitle(String nTitle) {
        this.title = nTitle;
    }
    public void setDescription(String nDescription) {
        this.description = nDescription;
    }
}
