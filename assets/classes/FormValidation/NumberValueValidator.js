export class NumberValueValidator {

    
    /** @type {string} */
    #nanErrorMessage = 'la valeur entrée n\'est pas un nombre';

    /** @type {string} */
    #minErrorMessage = 'le nombre est inférieur au minimum requis';

    /** @type {string} */
    #maxErrorMessage = 'le nombre est supérieur au maximum autorisé';

    /** @type {number|null} */
    #min = null;

    /** @type {number|null} */
    #max = null;
    
    constructor(options) {
        if(options.minErrorMessage) {
            this.#minErrorMessage = options.minErrorMessage;
        }
        if(options.maxErrorMessage) {
            this.#maxErrorMessage = options.maxErrorMessage;
        }
        if(options.min) {
            this.#min = options.min;
        }
        if(options.max) {
            this.#max = options.max;
        }
    }

    /**
     * 
     * @returns {string|null} errorMessage | null
     */
    validate(value) {
        if(!value.match(/\d+/) && value !== '') {
            return this.#nanErrorMessage.replace('{{value}}', value.toString());
        }
        const numberValue = parseInt(value);
        if(this.#min !== null) {
            if(numberValue < this.#min) {
                return this.#minErrorMessage.replace('{{value}}', value.toString());
            }
        }
        if(this.#max !== null) {
            if(numberValue > this.#max) {
                return this.#maxErrorMessage.replace('{{value}}', value.toString());
            }
        }
        return null;
    }
}

