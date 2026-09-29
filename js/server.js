import express from 'express';
import cors from 'cors';
import { NovaAI } from '@datalabrotterdam/nova-sdk';
import dotenv from 'dotenv';

dotenv.config({ path: './key.env' });

const app = express();

app.use(cors());
app.use(express.json());

const PORT = 3000;

const client = new NovaAI({
    apiKey: process.env.NOVA_API_KEY
});

app.post('/ask-nova', async (req, res) => {
    const userPrompt = req.body.prompt;

    try {
        const completion = await client.chat.completions.create({
            model: 'gemma4:26b',
            messages: [
                {
                    role: 'user',
                    content: userPrompt
                }
            ]
        });

        const answer = completion.choices[0]?.message?.content;

        res.json({ answer });

    } catch (error) {
        console.error('Nova error:', error);

        res.status(500).json({
            error: error.message
        });
    }
});

app.listen(PORT, () => {
    console.log(`Server draait op http://localhost:${PORT}`);
});