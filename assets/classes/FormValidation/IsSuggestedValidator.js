export class IsSuggestedValidator {
    /** @type {string} */
    #errorMessage;
    
    constructor(errorMessage = 'Veuillez sélectionner une entrée parmis les choix proposés') {
        this.#errorMessage = errorMessage;
    }

    /**
     * 
     * @returns {string|null} errorMessage | null
     */
    validate(value) {
        if(!value.suggested && value.value !== '') {
            return this.#errorMessage;
        }
        return null;
    }
}

