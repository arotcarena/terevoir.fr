export class IsTrueValidator {
    /** @type {string} */
    #errorMessage;
    
    constructor(errorMessage = 'Cette valeur doit être true') {
        this.#errorMessage = errorMessage;
    }

    /**
     * 
     * @returns {string|null} errorMessage | null
     */
    validate(value) {
        if(value !== true) {
            return this.#errorMessage;
        }
        return null;
    }
}