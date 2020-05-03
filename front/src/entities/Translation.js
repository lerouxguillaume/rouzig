import {Example} from "./Example";

export function Translation(language) {
    this.text = null;
    this.language = language;
    this.type = null;
    this.description = null;
    this.examples = [];
    this.load = function(object) {
        this.text = object.text;
        this.language = object.language;
        this.type = object.type;
        this.description = object.description;

        let _this = this;
        object.examples.forEach(function (example) {
            let newExample = new Example();
            newExample.load(example);
            _this.examples.push(newExample)
        })
    }
}