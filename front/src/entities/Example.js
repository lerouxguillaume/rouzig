export function Example() {
    this.fromLanguage = 'fr';
    this.fromText = null;
    this.toLanguage = 'br';
    this.toText = null;
    this.load = function(object) {
        this.fromLanguage = object.fromLanguage;
        this.fromText = object.fromText;
        this.toLanguage = object.toLanguage;
        this.toText = object.toText;
    }
}