<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        {{-- BOOSTRAPP --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    
    <style>
        #file-list img {
            width: 100px;
            margin: 5px;
        }
        #error-message {
            color: red;
        }



    </style>
</head>
<body>
    <input type="file" class="file-select" accept="image/*" capture="environment" name="file" id="file" multiple>
    <button id="upload-button">Subir</button>
    <div id="file-list"></div>
    <div id="error-message"></div>
    <span class="material-symbols-outlined">outbox</span>

    <script>
        let filesQueue = [];

        document.getElementById("file").addEventListener("change", (event) => {
            const files = event.target.files;
            filesQueue.push(...files);
            renderFiles();
        });

        document.getElementById("upload-button").addEventListener("click", async () => {
            await uploadFiles();
        });

        function renderFiles() {
            const fileList = document.getElementById("file-list");
            fileList.innerHTML = ''; // Clear the list
            filesQueue.forEach(file => {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                fileList.appendChild(img);
            });
        }

        async function uploadFiles() {
            const formData = new FormData();
            filesQueue.forEach(file => {
                formData.append("files[]", file);
            });

            try {
                const response = await fetch('{{ route('cola') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                console.log('Files uploaded successfully:', result);

                // Remove successfully uploaded files from the queue
                filesQueue = [];
                renderFiles();
                document.getElementById("error-message").textContent = ''; // Clear error message
            } catch (error) {
                console.error('Error uploading files:', error);
                document.getElementById("error-message").textContent = 'Error uploading files. Please try again.';
            }
        }
    </script>
</body>
</html>
