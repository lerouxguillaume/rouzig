import {Word} from "./Word";

export class User {
    constructor() {
        this.id = null;
        this.username = new Word();
        this.email = new Word();
    }
    load = function(object) {
        if (typeof object !== "undefined") {
            this.id = object.id;
            this.username = object.username;
            this.email = object.email;
        }
        return this;
    }
    jsonEncode = function() {
        return JSON.stringify(this);
    }
    decode = function(jsonString) {
        if (jsonString) {
            let object = JSON.parse(jsonString)
            this.id = object.id;
            this.email = object.email;
            this.username = object.username;
        }

        return this;
    }
}