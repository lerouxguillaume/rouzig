import {Example} from "./Example";
import {formatErrorCode} from "../utils/formatter";
import {Word} from "./Word";

export class Translation {
    constructor() {
        this.id = null;
        this.originalWord = new Word();
        this.translatedWord = new Word();
        this.status = null;
        this.examples = [];
        this.updatedAt = null;
    }
    load = function(object) {
        if (typeof object !== "undefined") {
            this.id = object.id;
            this.originalWord.load(object.originalWord);
            this.translatedWord.load(object.translatedWord);
            this.status = object.status;
            this.updatedAt = object.updatedAt;
            let _this = this;
            object.examples.forEach(function (example) {
                let newExample = new Example();
                newExample.load(example);
                _this.examples.push(newExample)
            })
        }
        return this;
    }
    loadError = function (path, code) {
        let currentProperty = path[0]
        switch (currentProperty) {
            case 'word' :
                this.wordError = formatErrorCode(code);
                break;
            case 'wordType' :
                this.wordTypeError = formatErrorCode(code);
                break;
            case 'language' :
                this.languageError = formatErrorCode(code);
                break;
            case 'description' :
                this.description = formatErrorCode(code);
                break;
            case 'examples':
                // eslint-disable-next-line no-case-declarations
                let exampleId = path[1];
                path.splice(0,2);
                this.examples[exampleId].loadError(path, code)
                break;
            default:
                console.error('unrecognized property : '+ currentProperty);
        }
    }
    post = function () {
        let examples = [];
        this.examples.forEach(function (example) {
            examples.push(example.post())
        })
        return {
            'originalWord' : this.originalWord,
            'translatedWord' : this.translatedWord,
            'examples': examples
        }
    }
    patch = function () {
        let examples = [];
        this.examples.forEach(function (example) {
            examples.push(example.patch())
        })
        return {
            'id' : this.id,
            'originalWord' : this.originalWord,
            'translatedWord' : this.translatedWord,
            'examples': examples
        }
    }
}