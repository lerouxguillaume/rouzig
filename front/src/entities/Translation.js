import {Example} from "./Example";

export function Translation(text) {
    this.text = text;
    this.language = '';
    this.type = '';
    this.description = '';
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