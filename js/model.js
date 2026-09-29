import { NovaAI } from '@datalabrotterdam/nova-sdk';

const client = new NovaAI({
    apiKey: 'KEY'
});

try {
    const models = await client.models.list();

    console.log(JSON.stringify(models, null, 2));
} catch (error) {
    console.error('Fout:', error);
}