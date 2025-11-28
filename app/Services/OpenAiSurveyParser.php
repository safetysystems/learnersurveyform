<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAiSurveyParser
{
    /**
     * Parse a survey image into structured data.
     *
     * @param string $absolutePath
     * @return array|null
     */
    public function parseImage(string $absolutePath): ?array
    {
        if (!file_exists($absolutePath)) {
            dd('Image file does not exist at path:', $absolutePath);
        }

        $imageData = base64_encode(file_get_contents($absolutePath));

        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an OCR/OMR engine for the AQTF Learner Questionnaire. ' .
                        'You read scanned forms and output ONLY strict JSON with answers and demographics.',
                ],
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'input_image',
                            'image_url' => [
                                'url' => 'data:image/png;base64,' . $imageData,
                            ],
                        ],
                        [
                            'type' => 'input_text',
                            'text' => <<<'PROMPT'
You will receive an image that may or may not be an AQTF Learner Questionnaire form.

If the image is not clearly this form (for example it is a random PDF page, a photo, or illegible), respond with:
{
  "valid": false,
  "reason": "short explanation"
}

If it IS a completed AQTF Learner Questionnaire, respond with:
{
  "valid": true,
  "reason": "short explanation",
  "answers": {
    "LQ21": 1,
    "LQ23": 4
  },
  "demographics": {
    "best_aspects": "text or null",
    "needs_improvement": "text or null",
    "qualification_full_title": "text or null",
    "qualification_level": 1,
    "training_broad_field": 3,
    "training_start_month": 3,
    "training_start_year": 2024,
    "is_apprenticeship_or_traineeship": true,
    "has_recognition_of_prior_learning": false,
    "speaks_language_other_than_english_at_home": false,
    "is_permanent_resident_or_citizen": true,
    "has_disability_or_impairment": false,
    "sex_code": 2,
    "age_band_code": 4,
    "atsi_origin_code": 1,
    "postcode": "3000"
  }
}

Use the official AQTF question codes (LQxx) as keys in "answers".
If a box is blank or unclear, omit that code.
Return ONLY JSON, no extra text.
PROMPT,
                        ],
                    ],
                ],
            ],
        ]);

        dd('Raw OpenAI response object:', $result);

        $content = $result->choices[0]->message->content ?? null;

        if (!is_string($content)) {
            return null;
        }

        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : null;
    }
}
