# Ask questions about the 2020 Olympics
This project uses the information on the 2020 Olympics dound on wikipedia.

<img width="910" alt="image" src="https://user-images.githubusercontent.com/92028931/231527160-17716349-b667-4f71-8b47-7616f6486099.png">

## How it works
This uses embeddings to perform a semantic similarity search for the question against each seaction of the wikipedia page.
We then rank order the results sorted by most similar, returing the index of the embedding.
We use this array of indexes to get the corresponding text.
We add the context to the openai chat endpoint, skimming off the top until x tokens have been reached (also adding the original question).
We then get an enswer based on the given context.

![image](https://user-images.githubusercontent.com/92028931/231528146-f627b54e-572a-4ecc-8c71-b4d267be0510.png)
