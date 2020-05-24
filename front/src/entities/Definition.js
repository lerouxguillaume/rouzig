import {Word} from "./Word";
import {Translation} from "./Translation";

export class Definition {
    constructor() {
        this.word = new Word();
        this.translations = [];
    }

    load = function(object) {
        this.word.load(object)
        let _this = this;
        object.translations.forEach(function (translation) {
            let newTranslation = new Translation();
            newTranslation.load(translation);
            _this.translations.push(newTranslation)
        })
    };
}