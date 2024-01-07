<?php

namespace App\Service;

use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class QueryEmbedding
{

    public function getQueryEmbedding($question): array
    {
        try {
            $result = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => $question,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception("Failed to generated query embedding!");
        }

        if (count($result['data']) == 0) {
            throw new Exception("Failed to generated query embedding!");
        }

        return $result['data'][0]['embedding'];
    }

    public function askQuestionStreamed($context, $question, $messages = [])
    {
        $system_template = "INSTRUCTIONS: Given the following extracted parts of a long document and a question, create a final answer using ONLY THE GIVEN DOCUMENT DATA NOT FROM YOUR TRAINED KNOWLEDGE BASE in the language the question is asked, if it's asked in English, answer in English and so on. If you can't fetch a proper answer from the GIVEN DATA then just say that you don't know the answer from the document. The answer must be completely within the given data not from outside sources. Don't try to give an answer like a search engine for everything. Give an answer as much as it is asked for. Be specific to the question and don't give full explanation with long answer all the time unless asked explicitly or highly relevant. When asked for how many, how much etc, try giving the quantifiable answer without giving the full lengthy explanation. Always answer in the same language the question is asked in. Give the answer in proper line breaks between paragraphs or sentences.
        Content: {context}\n\nQuestion: {question}\nHelpful Answer:";

        $extra_question = "\nPlease provide the answer in short paragraphs containing 2-3 sentences each. Give answer in the markdown rich format with proper headlines, bold, italics etc as per heirarchy and readability requirements. Make sure you follow all the given INSTRUCTIONS strictly when giving the answer with care. Do not answer like a generic AI, but act like a trained AI to answer questions based on the only info provided in the above CONTENT sections.";
        $system_prompt = str_replace("{context}", $context, $system_template);
        $system_prompt = str_replace("{question}", $question . $extra_question, $system_prompt);

        $messages[] = [
            'role' => 'user',
            'content' => $system_prompt
        ];
        // logger()->info($messages);
        try {
            return Openai::chat()->createStreamed([
                'model' => 'gpt-3.5-turbo-1106',
                'temperature' => 0.2,
                'messages' => $messages,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception("Failed to generate answer!");
        }
    }
}
