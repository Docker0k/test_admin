@push('styles')
    <style>
        .image-container {
            display: flex;
            gap: 10px;
        }

        .image-wrapper {
            position: relative;
        }

        .image-wrapper input[type="radio"] {
            display: none;
        }

        .image-wrapper img {
            border: 2px solid transparent;
            cursor: pointer;
            transition: border-color 0.3s ease;
            max-width: 100px;
            max-height: 100px;
        }

        /* Обводка при виборі */
        .image-wrapper input[type="radio"]:checked + img {
            border-color: blue;
        }
    </style>
@endpush
<div class="image-container">
    @if(count($images))
        <ul>
            @foreach($images as $image)
                <label class="image-wrapper">
                    <input type="radio" name="avatar" value="{{ $image->getFilename() }}" @if($admin->avatar == $image->getFilename()) checked @endif>
                    <img src="{{ asset('uploads/' . $image->getFilename()) }}" alt="Image {{ $loop->index }}" width="50" height="50">
                </label>
            @endforeach
        </ul>
    @endif
</div>
<!-- Інпут для завантаження зображення -->
<input type="file" id="uploadImage" accept="image/*">

@push('scripts')
    <script>
        document.getElementById('uploadImage').addEventListener('change', async (event) => {
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('image', file);

                try {
                    const response = await fetch('/admin/upload-image', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    });

                    if (response.ok) {
                        const data = await response.json();
                        addImageToContainer(data.imageUrl, data.filename);
                    } else {
                        alert('Помилка при завантаженні зображення');
                    }
                } catch (error) {
                    console.error('Помилка:', error);
                }
            }
        });

        function addImageToContainer(imageUrl, filename) {
            const container = $('.image-container');
            const newIndex = container.children.length;

            const label = document.createElement('label');
            label.classList.add('image-wrapper');
            label.innerHTML = `
            <input type="radio" name="avatar" value="${filename}">
            <img src="${imageUrl}" alt="Image ${newIndex}" width="50" height="50">
        `;
            container[0].appendChild(label);
        }
    </script>
@endpush
