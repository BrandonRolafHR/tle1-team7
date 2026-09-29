import 'dotenv/config'; // Laadt automatisch je .env variabelen

/**
 * Functie om een vraag naar Nova te sturen
 * @param {string} prompt - De vraag van de gebruiker
 * @returns {Promise<string>} - Het antwoord van de AI
 */
async function askNova(prompt) {
    const apiKey = process.env.NOVA_API_KEY;
    const apiUrl = process.env.NOVA_API_URL;

    if (!apiKey) {
        throw new Error("API Key ontbreekt! Check je .env bestand.");
    }

    // De payload (het data-pakketje)
    const body = JSON.stringify({
        model: "nova-pro", // Pas dit aan naar het model dat je gebruikt
        messages: [
            { role: "user", content: prompt }
        ],
        temperature: 0.7
    });

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${apiKey}`,
                'Content-Type': 'application/json'
            },
            body: body
        });

        // Controleer op fouten zoals 401 (unauthorized) of 429 (too many requests)
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(`API Error: ${response.status} - ${JSON.stringify(errorData)}`);
        }

        const data = await response.json();

        // De route naar het tekstveld verschilt per provider. 
        // Dit is de standaard OpenAI-stijl die veel Nova-providers gebruiken:
        return data.choices[0].message.content;

    } catch (error) {
        console.error("Er ging iets mis tijdens het aanroepen van Nova:");
        return `Fout: ${error.message}`;
    }
}

// --- TEST DE IMPLEMENTATIE ---
const vraag = "Geef me een korte tip voor een betere programmeur.";

console.log("Nova is aan het nadenken...");

askNova(vraag).then(antwoord => {
    console.log("\n--- ANTWOORD VAN NOVA ---");
    console.log(antwoord);
});