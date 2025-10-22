<x-layout.app>
<x-slot:title>Guruhni Filtirlash</x-slot:title>

<style>    
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

        /* Select elementlar uchun border va styling */
        .bootstrap-select .dropdown-toggle {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem 0.75rem !important;
            background-color: #fff !important;
        }
        
        .bootstrap-select .dropdown-toggle:focus {
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }
        
        .bootstrap-select .filter-option {
            color: #212529 !important;
        }
        
        .bootstrap-select .dropdown-menu {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }
        
        .bootstrap-select .dropdown-menu.inner {
            max-height: 200px !important;
            overflow-y: auto !important;
        }

        /* Form selectlar uchun */
        .form-select {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }
        
        .form-select:focus {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        /* Tugmalar bir qatorda */
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
    </style>

        <!-- Breadcrumb -->
        <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home.page') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> Asosiy
                    </a> 
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('schedule.index') }}"  class="text-decoration-none">
                        Dars jadvalini boshqarish
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Guruxni filtirlash
                    </a>
                </li>
            </ol>
        </nav>
    </div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-3">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">Guruhni Filtirlash</div>
        <div class="card-body">
            <form action="{{ route('calendar.show') }}" method="GET" id="filterForm"> 
                <div class="row mb-3">
                    <!-- Program -->
                    <div class="col-md-4">
                        <label>Dastur</label>
                        <select name="program_id" id="program_id" class="selectpicker w-100" data-live-search="true" required>
                            <option value="">Tanlang</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ ($selectedProgram ?? '') == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Group -->
                    <div class="col-md-4">
                        <label>Guruh</label>
                        <select name="group_id" id="group_id" class="selectpicker w-100" data-live-search="true" required disabled>
                            <option value="">Tanlang</option>
                        </select>
                    </div>

                    <!-- Semester -->
                    <div class="col-md-4">
                        <label>Semestr</label>
                        <select name="semester_id" id="semester_id" class="selectpicker w-100" data-live-search="true" required disabled>
                            <option value="">Tanlang</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-2">
                    <button type="reset" class="btn btn-secondary">Tozalash</button>
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            // Dastur tanlanganda
            $('#program_id').change(function() {
                let programId = $(this).val();
                $('#group_id').prop('disabled', !programId);
                $('#semester_id').prop('disabled', true).val('');
                $('.selectpicker').selectpicker('refresh');

                if (programId) {
                    $.get("{{ url('filter/groups-by-program') }}/" + programId, function(data) {
                        let options = '<option value="">Tanlang</option>';
                        data.forEach(g => options += `<option value="${g.id}">${g.group_name}</option>`);
                        $('#group_id').html(options).prop('disabled', false);
                        $('.selectpicker').selectpicker('refresh');
                    });
                } else {
                    $('#group_id').html('<option value="">Tanlang</option>');
                    $('.selectpicker').selectpicker('refresh');
                }
            });

            // Guruh tanlanganda
            $('#group_id').change(function() {
                let groupId = $(this).val();
                $('#semester_id').prop('disabled', !groupId);
                $('.selectpicker').selectpicker('refresh');

                if (groupId) {
                    $.get("{{ url('filter/semesters-by-group') }}/" + groupId, function(data) {
                        let options = '<option value="">Tanlang</option>';
                        data.forEach(s => options += `<option value="${s.id}">${s.name}</option>`);
                        $('#semester_id').html(options).prop('disabled', false);
                        $('.selectpicker').selectpicker('refresh');
                    });
                } else {
                    $('#semester_id').html('<option value="">Tanlang</option>');
                    $('.selectpicker').selectpicker('refresh');
                }
            });

        });
    </script>

    {{-- Bootstrap Select --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>

</x-layout.app>
