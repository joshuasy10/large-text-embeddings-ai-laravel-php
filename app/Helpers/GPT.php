<?php

namespace App\Helpers;
use Exception;
use Orhanerday\OpenAi\OpenAi;

class GPT
{


    private $client;
    // set your OpenAI API key and return the client
    public static function getClient()
    {
        $client = new OpenAi(env('OPENAI_API_KEY'));
        return $client;
    }

    // Chat endpoint
    public static function chat($message, $context)
    {
        $client = self::getClient();
        $response = $client->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => self::formatPromptWithContext($message, $context),
            'temperature' => 0,
            'max_tokens' => 500,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
            'top_p' => 1,

        ]);
        $info = json_decode($response);
//        dd($info);

        if (property_exists($info, 'error')) {
            dd($info);
            throw new Exception(json_encode($info->error));
        }
        return $response;
    }



    public static function formatPromptWithContext(string $prompt, string $context): array
    {
        $system = "Answer the question as truthfully as possible using the provided text, and if the answer is not contained within the text below, say 'Sorry, I don't know'.
Context:
$context";
        $prompt = "$prompt";

        return [
            [
                "role" => "system",
                "content" => $system
            ], [
                "role" => "user",
                "content" => $prompt
            ]
        ];
    }


    public static function dotProduct(array $a, array $b): float {
        $result = 0.0;
        for ($i = 0; $i < count($a); $i++) {
            $result += $a[$i] * $b[$i];
        }
        return $result;
    }


    public static function semantic_search(array $questionEmbedding, array $contextEmbeddingsList, int $n = 5): array {
        // Calculate the similarity scores between the question embedding and each context embedding
        $similarityScores = array_map(function ($embedding) use ($questionEmbedding) {
            // Ensure that $embedding and $queryEmbedding are arrays of numeric values
            $embedding = array_map('floatval', $embedding);
            $questionEmbedding = array_map('floatval', $questionEmbedding);
            return self::dotProduct($embedding, $questionEmbedding);
        }, $contextEmbeddingsList);

        // Sort the context embeddings by similarity score in descending order
        $sortedContextEmbeddings = [];
        for ($i = 0; $i < count($contextEmbeddingsList); $i++) {
            $sortedContextEmbeddings[$i]['embeddings'] = $contextEmbeddingsList[$i];
            $sortedContextEmbeddings[$i]['similarity'] = $similarityScores[$i];
            $sortedContextEmbeddings[$i]['index'] = $i;
        }
        usort($sortedContextEmbeddings, function ($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // Return the top N most similar context embeddings
        return array_slice($sortedContextEmbeddings, 0, $n);

        // Remove the 'similarity' field from the top results
        $topResults = array_map(function ($result) {
            unset($result['similarity']);
            return $result;
        }, $topResults);

        return $topResults;
    }



    public static function getEmbeddings($text){
        $client = self::getClient();
        $response = $client->embeddings([
            'model' => 'text-embedding-ada-002',
            'input' => $text,
        ]);
        $info = json_decode($response);
        if (property_exists($info, 'error')) {
//            dd($info);
            throw new Exception(json_encode($info->error));
        }
        return [
            "embeddings" => \Arr::map($info->data, fn($item) => $item->embedding),
            "usage" => $info->usage->total_tokens,
            "model" => $info->model,
        ];
    }
}
