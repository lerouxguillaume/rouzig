export function Example(text) {
    this.fromLanguage = text;
    this.fromText = '';
    this.toLanguage = '';
    this.toText = '';
    this.load = function(object) {
        this.fromLanguage = object.fromLanguage;
        this.fromText = object.fromText;
        this.toLanguage = object.toLanguage;
        this.toText = object.toText;
    }
}