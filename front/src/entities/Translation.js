import {Example} from "./Example";
// eslint-disable-next-line no-unused-vars
import {formatErrorCode} from "../utils/formatter";
import {Word} from "./Word";
import {Status} from "../utils/enum";
import {parse} from "../utils/common";

export class Translation {
    constructor() {
        this.id = null;
        this.originalWord = new Word();
        this.translatedWord = new Word();
        this.status = null;
        this.examples = [];
        this.updatedAt = null;
        Object.defineProperty(this, 'statusLabel', {
            get () {
                return Status().find(element => element.value === this.status).text;
            },
        });

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
    loadErrors = function (errors) {
        let violations = errors.violations;
        let _this = this;
        violations.forEach(function (violation) {
            let parsedPropertyPath = parse(violation.propertyPath);
            let currentProperty = parsedPropertyPath[0]
            switch (currentProperty) {
                case 'originalWord':
                    parsedPropertyPath.splice(0,1);
                    _this.originalWord.loadError(parsedPropertyPath, violation.payload.code);
                    break;
                case 'translatedWord' :
                    parsedPropertyPath.splice(0,1);
                    _this.translatedWord.loadError(parsedPropertyPath, violation.payload.code);
                    break;
                case 'examples':
                    console.log(parsedPropertyPath);
                    // eslint-disable-next-line no-case-declarations
                    let exampleId = parsedPropertyPath[1];
                    parsedPropertyPath.splice(0,2);
                    this.examples[exampleId].loadError(parsedPropertyPath, currentProperty)
                    break;
                default:
                    console.error('unrecognized property : '+ currentProperty);
            }
        });
        return this;
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