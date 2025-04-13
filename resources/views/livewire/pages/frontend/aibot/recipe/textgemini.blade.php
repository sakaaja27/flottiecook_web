<div id="text-screen" class="hidden">
    <div class="flex flex-col md:flex-row items-start justify-start w-full space-y-4 md:space-y-0 md:space-x-4">
        <div class="w-full md:w-1/2">
            <label class="block text-lg font-semibold text-gray-700 mb-2">Search your recipe</label>
            <input type="text" placeholder="Search your recipe"
                class="w-full p-3 border rounded-lg bg-white shadow-md" />
            <button onclick="SendTextGemini()"
                class="mt-4 w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">
                Search

        </div>
        <div class="w-full md:w-1/2 h-64 relative">
            <div id="result-card"
                class="w-[500px] h-[300px] p-1 border-2 border-gray-200 bg-gray-50 rounded-lg overflow-y-auto">
                <div class="w-full mb-6 px-2">
                    <label class="font-bold text-blue-700">Name Recipe:</label>
                    <textarea id="namerecipetext-textarea"
                        class="w-full h-20 p-2 mt-1 border-2 border-blue-100 bg-blue-50 rounded-lg text-black placeholder-gray-500 resize-none"
                        disabled placeholder="Nama resep yang dicari akan tampil disini"></textarea>
                </div>
                <div class="w-full mt-6 px-2">
                    <label class="font-bold text-green-600 block mt-2">Ingredients:</label>
                    <textarea id="ingredienttext-textarea"
                        class="w-full h-60 p-2 mt-1 border-2 border-green-50 bg-green-50 rounded-lg text-black placeholder-gray-500 resize-none"
                        disabled placeholder="Alat dan bahan yang dibutuhkan akan tampil disini"></textarea>
                </div>
                <div class="w-full mt-6 px-2">
                    <label class="font-bold text-yellow-600 block mt-2">Process:</label>
                    <textarea id="makeprocesstext-textarea"
                        class="w-full h-60 p-2 mt-1 border-2 border-yellow-50 bg-yellow-50 rounded-lg text-black placeholder-gray-500 resize-none"
                        disabled placeholder="Proses pembuatan akan tampil disini"></textarea>
                </div>
            </div>
            <div id="loading-icon-text"
                class="hidden absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg w-[650px] h-[300px]">
                <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
                <span class="ml-2 text-gray-700">Memproses Output...</span>
            </div>
        </div>
    </div>
</div>

<script>
    async function SendTextGemini() {
        const loadingIconText = document.getElementById('loading-icon-text');
        const nameRecipeTextareaText = document.getElementById('namerecipetext-textarea');
        const ingredientTextareaText = document.getElementById('ingredienttext-textarea');
        const makeProcessTextareaText = document.getElementById('makeprocesstext-textarea');
        loadingIconText.classList.remove('hidden');
        nameRecipeTextareaText.value = '';
        ingredientTextareaText.value = '';
        makeProcessTextareaText.value = '';
        const formData = new FormData();
        formData.append('text', document.querySelector('input[type="text"]').value);

        try {
            const response = await fetch('/aibotwithtext', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: formData
            });

            const data = await response.json();
            if (data.status === 'success') {
                const result = data.result;
                const nameRecipe = result.match(/\[NAMA MAKANAN\]([\s\S]*?)\[ALAT DAN BAHAN\]/);
                const ingredient = result.match(/\[ALAT DAN BAHAN\]([\s\S]*?)\[CARA PEMBUATAN\]/);
                const makeProcess = result.match(/\[CARA PEMBUATAN\]([\s\S]*)/);

                console.log('Full result from API:', result);

                nameRecipeTextareaText.value = nameRecipe ? nameRecipe[1].replace(/\*/g, '').trim() :
                    'Tidak ada hasil';
                ingredientTextareaText.value = ingredient ? ingredient[1].replace(/\*/g, '').trim() :
                    'Tidak ada hasil';
                makeProcessTextareaText.value = makeProcess ? makeProcess[1].replace(/\*/g, '').trim() :
                    'Tidak ada hasil';
            } else {
                nameRecipeTextareaText.value = 'Tidak ada hasil';
                ingredientTextareaText.value = 'Tidak ada hasil';
                makeProcessTextareaText.value = 'Tidak ada hasil';
            }
        } catch (error) {
            nameRecipeTextareaText.value = 'Error: ' + error.message;
            ingredientTextareaText.value = 'Error: ' + error.message;
            makeProcessTextareaText.value = 'Error: ' + error.message;
        } finally {
            loadingIconText.classList.add('hidden');
        }
    }
</script>
