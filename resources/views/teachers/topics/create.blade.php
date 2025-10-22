<x-layout.app>
    <x-slot:title>
        Mavzular
    </x-slot:title>

    <style>
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .file-upload {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        .file-upload:hover {
            border-color: #0d6efd;
            background: #e7f1ff;
        }
        .file-upload.dragover {
            border-color: #0d6efd;
            background: #d1e7ff;
        }
        .file-preview {
            max-width: 100px;
            max-height: 100px;
        }
        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #0dcaf0);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0b5ed7, #0ba8d9);
        }
        .file-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .breadcrumb {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 20px;
        }
        .breadcrumb-item a {
            color: #495057;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .breadcrumb-item a:hover {
            color: #0d6efd;
        }
        .breadcrumb-item.active {
            color: #6c757d;
            font-weight: 600;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
            font-weight: bold;
        }
    </style>


    <!-- Breadcrumb -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home.page') }}" class="text-decoration-none">
                        <i class="fas fa-home pe-1"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('teacher.topic', $groupSubject->id) }}" class="text-decoration-none">
                        Biriktirilgan fanlar
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('topics.showByGroupSubject', $groupSubject->id) }}" class="text-decoration-none">
                        {{ $groupSubject->group->group_name ?? '-' }} guruh 
                        | {{ $groupSubject->subject->name_uz ?? '-' }} fani mavzulari
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Mavzu yaratish
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0">➕ Yangi Mavzu Yaratish</h4>
                        </div>
                        <div class="card-body p-4">
                            <form id="createTopicForm" action="{{ route('teacherTopics.store', $groupSubject->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Mavzu sarlavhasi -->
                                <div class="mb-4">
                                    <label for="topicTitle" class="form-label">
                                        <strong>Mavzu sarlavhasi *</strong>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control" 
                                        id="topicTitle" 
                                        name="title"
                                        placeholder="Mavzu nomini kiriting..."
                                        required
                                        value="{{ old('title') }}"
                                    >
                                    @error('title')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Fayl yuklash -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        <strong>Fayllarni yuklash</strong>
                                    </label>
                                    <div class="file-upload" id="fileUploadArea">
                                        <div class="mb-3">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                            <h5>Fayllarni bu yerga tortib keling</h5>
                                            <p class="text-muted">Yoki</p>
                                        </div>
                                        <input 
                                            type="file" 
                                            id="fileInput" 
                                            name="file"
                                            class="d-none" 
                                            multiple
                                            accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.mp4,.avi"
                                        >
                                        <button 
                                            type="button" 
                                            class="btn btn-primary"
                                            onclick="document.getElementById('fileInput').click()"
                                        >
                                            📁 Fayl tanlash
                                        </button>
                                        <div class="form-text mt-2">
                                            PDF, Word, PowerPoint, Rasm, Video fayllar (maks. 10MB)
                                        </div>
                                    </div>

                                    <!-- Yuklangan fayllar ro'yxati -->
                                    <div id="fileList" class="mt-3"></div>
                                    @error('file')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Yashirin file inputlar (JavaScript bilan qo'shiladi) -->
                                <div id="hiddenFileInputs"></div>

                                <!-- Amallar tugmalari -->
                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                        ❌ Bekor qilish
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        ✅ Mavzuni Saqlash
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Fayl yuklash funksiyalari
        const fileInput = document.getElementById('fileInput');
        const fileUploadArea = document.getElementById('fileUploadArea');
        const fileList = document.getElementById('fileList');
        const form = document.getElementById('createTopicForm');
        const hiddenFileInputs = document.getElementById('hiddenFileInputs');

        let uploadedFiles = [];

        // Drag and Drop funksiyalari
        fileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadArea.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', () => {
            fileUploadArea.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        // Fayl tanlash
        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        // Fayllarni qayta ishlash
        function handleFiles(files) {
            for (let file of files) {
                if (validateFile(file)) {
                    uploadedFiles.push(file);
                    displayFile(file);
                }
            }
            updateFileInput();
        }

        // Fayl validatsiyasi
        function validateFile(file) {
            const maxSize = 10 * 1024 * 1024; // 10MB
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'image/jpeg',
                'image/png',
                'video/mp4',
                'video/avi'
            ];

            if (file.size > maxSize) {
                alert(`❌ ${file.name} fayli hajmi 10MB dan katta!`);
                return false;
            }

            if (!allowedTypes.includes(file.type)) {
                alert(`❌ ${file.name} fayl formati qo'llab-quvvatlanmaydi!`);
                return false;
            }

            return true;
        }

        // Faylni ekranga chiqarish
        function displayFile(file) {
            const fileElement = document.createElement('div');
            fileElement.className = 'file-item d-flex align-items-center justify-content-between p-3 border rounded mb-2';
            fileElement.dataset.fileName = file.name;
            
            const fileInfo = document.createElement('div');
            fileInfo.className = 'd-flex align-items-center';
            
            const fileIcon = getFileIcon(file.type);
            const fileSize = (file.size / (1024 * 1024)).toFixed(2);
            
            fileInfo.innerHTML = `
                <span class="fs-4 me-3">${fileIcon}</span>
                <div>
                    <div class="fw-bold">${file.name}</div>
                    <small class="text-muted">${fileSize} MB</small>
                </div>
            `;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-outline-danger';
            removeBtn.innerHTML = '❌';
            removeBtn.onclick = () => removeFile(file.name);

            fileElement.appendChild(fileInfo);
            fileElement.appendChild(removeBtn);
            fileList.appendChild(fileElement);
        }

        // Fayl ikonkasi
        function getFileIcon(fileType) {
            const icons = {
                'application/pdf': '📄',
                'application/msword': '📝',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document': '📝',
                'application/vnd.ms-powerpoint': '📊',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation': '📊',
                'image/jpeg': '🖼️',
                'image/png': '🖼️',
                'video/mp4': '🎥',
                'video/avi': '🎥'
            };
            return icons[fileType] || '📎';
        }

        // Faylni o'chirish
        function removeFile(fileName) {
            uploadedFiles = uploadedFiles.filter(file => file.name !== fileName);
            // UI dan o'chirish
            const fileElement = document.querySelector(`[data-file-name="${fileName}"]`);
            if (fileElement) {
                fileElement.remove();
            }
            updateFileInput();
        }

        // File inputni yangilash
        function updateFileInput() {
            // Eski yashirin inputlarni tozalash
            hiddenFileInputs.innerHTML = '';
            
            // Yangi DataTransfer yaratish
            const dataTransfer = new DataTransfer();
            
            // Har bir faylni DataTransfer ga qo'shish
            uploadedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            
            // Asosiy file inputni yangilash
            fileInput.files = dataTransfer.files;
            
            // Ko'rish uchun yashirin inputlar yaratish (debug uchun)
            uploadedFiles.forEach((file, index) => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `file_names[${index}]`;
                hiddenInput.value = file.name;
                hiddenFileInputs.appendChild(hiddenInput);
            });
            
            console.log('File input yangilandi:', fileInput.files.length + ' ta fayl');
        }

        // Formani yuborish
        form.addEventListener('submit', (e) => {
            const topicTitle = document.getElementById('topicTitle').value;

            if (!topicTitle.trim()) {
                e.preventDefault();
                alert('❌ Iltimos, mavzu sarlavhasini kiriting!');
                return;
            }

            // File inputni oxirgi marta yangilash
            updateFileInput();
            
            console.log('Form yuborilmoqda...');
            console.log('Fayllar:', fileInput.files);
        });

        // Demo ma'lumotlarni to'ldirish
        function fillDemoData() {
            document.getElementById('topicTitle').value = 'Algebraik ifodalar va ularning xossalari';
        }

        // Demo ma'lumotlarni to'ldirish tugmasi (test uchun)
        document.addEventListener('DOMContentLoaded', () => {
            const demoButton = document.createElement('button');
            demoButton.type = 'button';
            demoButton.className = 'btn btn-outline-info btn-sm position-fixed';
            demoButton.style.bottom = '20px';
            demoButton.style.right = '20px';
            demoButton.innerHTML = '🎯 Demo ma\'lumot';
            demoButton.onclick = fillDemoData;
            document.body.appendChild(demoButton);
        });
    </script>
</x-layout.app>