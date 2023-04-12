# Ask questions about the 2020 Olympics
This project uses the information on the 2020 Olympics found on wikipedia.

<img width="910" alt="image" src="https://user-images.githubusercontent.com/92028931/231527160-17716349-b667-4f71-8b47-7616f6486099.png">

## How it works
<ol>
<li>This uses embeddings to perform a semantic similarity search for the question against each section of the wikipedia page.</li>
<li>We then rank order the results sorted by most similar, returning the index of the embedding.</li>
<li>We use this array of indexes to get the corresponding text.</li>
<li>We add the context to the openai chat endpoint, skimming off the top until x tokens have been reached (also adding the original question).</li>
<li>We then get an answer based on the given context.</li>
</ol

<img width="769" alt="image" src="https://user-images.githubusercontent.com/92028931/231528734-cb3b99bc-7dc6-46c3-9741-68087b50b6b5.png">
