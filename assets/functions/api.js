export async function apiFetch(entrypoint, options = {}) {
    const response = await fetch(entrypoint, {
        method: 'GET',
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        ...options
    });
    const data = await response.json();
    if(response.ok) {
        return data;
    } else {
        if(data.errors) {
            throw new ApiError(data.errors);
        }
        console.error('response status code != 200');
    }
    
} 


export class ApiError {
    errors;
    
    constructor(errors) {
        this.errors = errors;
    }
}