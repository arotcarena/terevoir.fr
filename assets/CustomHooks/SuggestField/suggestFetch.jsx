import { useState } from "react";
import { apiFetch } from "../../functions/api";




export const useSuggestFetch = (entrypoint, convert) => {
    const [suggests, setSuggests] = useState(null);

    return {
        suggests: suggests,
        searchSuggests: async q => {
            try {
                const result = await apiFetch(entrypoint+q);
                const data = convert(result);
                setSuggests(data);

            } catch(e) {
                console.error('erreur api address');
                setSuggests(null);
            }
        },
        initialize: () => setSuggests(null)
    }
}

