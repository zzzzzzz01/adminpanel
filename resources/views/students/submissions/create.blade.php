<x-layout.app>
    <x-slot:title>
        Vazifa yuklash
    </x-slot:title>

    <div class="container mt-4">
        <h4>{{ $assignment->title }}</h4>
        <p>Topshirish muddati: {{ $assignment->due_date }} {{ $assignment->due_time }}</p>

        <form action="{{ route('submissions.store', $assignment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

            <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">

            <div class="mb-3">
                <label for="file" class="form-label">Faylni yuklang</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Izoh (ixtiyoriy)</label>
                <textarea name="comment" id="comment" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Yuborish</button>
        </form>
    </div>


    <style>
        /* * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } */
        
        /* body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        } */
        
        .container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            padding: 35px;
            transition: transform 0.3s ease;
        }
        
        .container:hover {
            transform: translateY(-5px);
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
        }
        
        .deadline {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 16px;
            color: #2c3e50;
            border-left: 5px solid #3498db;
            display: flex;
            align-items: center;
        }
        
        .deadline i {
            margin-right: 10px;
            color: #3498db;
        }
        
        .deadline strong {
            color: #e74c3c;
            margin-left: 5px;
        }
        
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 35px;
            text-align: center;
            margin-bottom: 25px;
            transition: all 0.3s;
            position: relative;
            cursor: pointer;
        }
        
        .upload-area:hover, .upload-area.dragover {
            border-color: #3498db;
            background-color: #f0f8ff;
            transform: scale(1.01);
        }
        
        .upload-area i {
            font-size: 56px;
            color: #3498db;
            margin-bottom: 20px;
            display: block;
            transition: transform 0.3s;
        }
        
        .upload-area:hover i {
            transform: scale(1.1);
        }
        
        .upload-text {
            margin-bottom: 20px;
            color: #7f8c8d;
            font-size: 18px;
        }
        
        .browse-btn {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        }
        
        .browse-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        }
        
        .file-info {
            display: none;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: left;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .file-info h3 {
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 18px;
            display: flex;
            align-items: center;
        }
        
        .file-info h3 i {
            margin-right: 10px;
            color: #3498db;
        }
        
        .file-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
            padding: 10px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .file-name {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .file-size {
            color: #7f8c8d;
            font-weight: 500;
        }
        
        .progress-area {
            display: none;
            margin-top: 20px;
        }
        
        .progress-bar {
            height: 10px;
            width: 100%;
            background-color: #f0f0f0;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress {
            height: 100%;
            width: 0%;
            background: linear-gradient(to right, #2ecc71, #27ae60);
            transition: width 0.5s ease;
        }
        
        .progress-status {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            font-size: 14px;
            color: #7f8c8d;
        }
        
        textarea {
            width: 100%;
            padding: 18px;
            border: 2px solid #ddd;
            border-radius: 10px;
            resize: vertical;
            min-height: 120px;
            margin-bottom: 25px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .submit-btn {
            background: linear-gradient(to right, #2ecc71, #27ae60);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(46, 204, 113, 0.4);
        }
        
        .submit-btn:disabled {
            background: linear-gradient(to right, #ccc, #bbb);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 15px;
            margin-top: 15px;
            display: none;
            background-color: #fde8e8;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
            animation: shake 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .supported-formats {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 15px;
            line-height: 1.5;
        }
        
        .form-footer {
            text-align: center;
            margin-top: 25px;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .success-message {
            display: none;
            text-align: center;
            color: #27ae60;
            background-color: #e9f7ef;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            animation: fadeIn 0.5s ease;
        }
    </style>

    <!-- <div class="container">
        <h1><i class="fas fa-file-upload"></i> Topshiriq Yuklash</h1>
        
        <div class="deadline">
            <i class="fas fa-clock"></i>
            Topshirish muddati: <strong>2025–09–14 19:31:00</strong>
        </div>
        
        <form action="{{ route('submissions.store', $assignment->id) }}" id="uploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="upload-area" id="uploadArea">
                <i class="fas fa-cloud-upload-alt"></i>
                <p class="upload-text">Faylni shu yerga tortib keling yoki</p>
                <button type="button" class="browse-btn">Fayl tanlash</button>
                <input type="file" name="file" id="fileInput" hidden>
                <p class="supported-formats">Qo'llab-quvvatlanadigan formatlar: PDF, DOC, DOCX, JPEG, PNG, ZIP, RAR (Maks. hajm: 10MB)</p>
            </div>
            
            <div class="file-info" id="fileInfo">
                <h3><i class="fas fa-file"></i> Tanlangan fayl:</h3>
                <div class="file-details">
                    <span class="file-name" id="fileName">file.pdf</span>
                    <span class="file-size" id="fileSize">0 KB</span>
                </div>
                <div class="progress-area" id="progressArea">
                    <div class="progress-bar">
                        <div class="progress" id="progress"></div>
                    </div>
                    <div class="progress-status">
                        <span id="progressPercentage">0%</span>
                        <span id="progressStatus">Yuklanmoqda...</span>
                    </div>
                </div>
            </div>
            
            <div class="error-message" id="errorMessage">
                <i class="fas fa-exclamation-circle"></i> Xatolik: Fayl hajmi 10MB dan oshmasligi kerak!
            </div>
            
            <textarea name="comment" placeholder="Izoh (ixtiyoriy)" id="comment"></textarea>
            
            <button type="submit" class="submit-btn" id="submitBtn" disabled>
                <i class="fas fa-paper-plane"></i> Yuborish
            </button>
        </form>
        
        <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle"></i> Topshiriq muvaffaqiyatli yuklandi!
        </div>
        
        <div class="form-footer">
            &copy; 2025 Topshiriq Tizimi
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const progressArea = document.getElementById('progressArea');
            const progress = document.getElementById('progress');
            const progressPercentage = document.getElementById('progressPercentage');
            const progressStatus = document.getElementById('progressStatus');
            const errorMessage = document.getElementById('errorMessage');
            const submitBtn = document.getElementById('submitBtn');
            const comment = document.getElementById('comment');
            const uploadForm = document.getElementById('uploadForm');
            const successMessage = document.getElementById('successMessage');
            
            // Fayl tanlash tugmasi
            uploadArea.querySelector('.browse-btn').addEventListener('click', function() {
                fileInput.click();
            });
            
            // Drag and drop funksiyasi
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                uploadArea.classList.add('dragover');
            }
            
            function unhighlight() {
                uploadArea.classList.remove('dragover');
            }
            
            uploadArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length) {
                    fileInput.files = files;
                    handleFiles(files);
                }
            }
            
            // Fayl tanlanganda
            fileInput.addEventListener('change', function() {
                handleFiles(this.files);
            });
            
            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];
                    const fileSizeMB = file.size / (1024 * 1024); // MB da
                    
                    // Fayl hajmini tekshirish
                    if (fileSizeMB > 10) {
                        showError();
                        return;
                    }
                    
                    hideError();
                    
                    // Fayl ma'lumotlarini ko'rsatish
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    fileInfo.style.display = 'block';
                    
                    // Yuklash jarayonini simulatsiya qilish
                    simulateUpload();
                    
                    // Yuborish tugmasini faollashtirish
                    submitBtn.disabled = false;
                }
            }
            
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            function showError() {
                errorMessage.style.display = 'block';
                fileInfo.style.display = 'none';
                submitBtn.disabled = true;
                
                // Xatolik xabarini 5 soniyadan keyin yashirish
                setTimeout(hideError, 5000);
            }
            
            function hideError() {
                errorMessage.style.display = 'none';
            }
            
            function simulateUpload() {
                progressArea.style.display = 'block';
                let width = 0;
                
                const interval = setInterval(() => {
                    if (width >= 100) {
                        clearInterval(interval);
                        progressStatus.textContent = "Yuklandi!";
                    } else {
                        width += 5;
                        progress.style.width = width + '%';
                        progressPercentage.textContent = width + '%';
                        
                        if (width < 30) {
                            progressStatus.textContent = "Yuklanmoqda...";
                        } else if (width < 70) {
                            progressStatus.textContent = "Yuklash davom etmoqda...";
                        } else {
                            progressStatus.textContent = "Yuklash tugamoqda...";
                        }
                    }
                }, 100);
            }
            
            // Formani yuborish
            uploadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Bu yerda haqiqiy serverga yuborish logikasi bo'ladi
                // Simulyatsiya uchun:
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yuklanmoqda...';
                
                setTimeout(function() {
                    successMessage.style.display = 'block';
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Yuborish';
                    
                    // Formani tozalash
                    setTimeout(function() {
                        uploadForm.reset();
                        fileInfo.style.display = 'none';
                        progressArea.style.display = 'none';
                        successMessage.style.display = 'none';
                        submitBtn.disabled = true;
                    }, 3000);
                }, 2000);
            });
        });
    </script> -->











</x-layout.app>
