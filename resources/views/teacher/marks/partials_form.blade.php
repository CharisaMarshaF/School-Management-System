<form action="{{ route('teacher.marks.register.save') }}" method="POST" class="mb-5 p-4 border rounded bg-light">
    @csrf
    <input type="hidden" name="exam_id" value="{{ $exam_id }}">
    <input type="hidden" name="class_id" value="{{ $class_id }}">
    <input type="hidden" name="student_id" value="{{ $student->id }}">

    <h5 class="mb-3 text-primary">{{ $student->name }}</h5>
    <div class="row">
        @foreach($schedules as $subject)
            @php
                $prefix="marks[{$subject->subject_id}]";
                $mk=$marks[$student->id.'_'.$subject->subject_id] ?? null;
                $ttl = 0;
                if($mk) {
                    $ttl = ($mk->class_work ?? 0) + ($mk->home_work ?? 0) + ($mk->test_work ?? 0) + ($mk->exam ?? 0);
                }
                $pass = $ttl >= $subject->passing_marks;
                $gradeKey = $student->id.'_'.$subject->subject_id;
                $grade = $gradesByMark[$gradeKey] ?? '-';
            @endphp

            <div class="col-md-6 mb-4">
                <div class="border p-3 rounded shadow-sm bg-white">
                    <h6 class="text-dark fw-bold mb-3">{{ $subject->subject->name }} 
                        <span class="text-muted">[Full:{{ $subject->full_marks }}, Pass:{{ $subject->passing_marks }}]</span>
                    </h6>

                    @foreach(['class_work'=>'Class Work','home_work'=>'Home Work','test_work'=>'Test Work','exam'=>'Exam'] as $f=>$label)
                        <div class="form-group mb-2">
                            <label>{{ $label }}</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="{{ $prefix }}[{{ $f }}]" 
                                   value="{{ old("marks.{$subject->subject_id}.{$f}", $mk->$f ?? 0) }}" required>
                        </div>
                    @endforeach

                    <div class="mt-2 fw-bold text-{{ $pass?'success':'danger' }} total-mark-info" 
                         data-full="{{ $subject->full_marks }}" 
                         data-passing="{{ $subject->passing_marks }}">
                        Total Marks: {{ $ttl }} / {{ $subject->full_marks }} - {{ $pass ? 'PASS' : 'FAIL' }}
                    </div>
                    <div class="text-primary fw-semibold mt-1">Grade: {{ $grade }}</div>

                    <button type="button"
                        onclick="submitSingleSubject(this, '{{ route('teacher.marks.register.subject.save') }}', {{ $student->id }}, {{ $subject->subject_id }})"
                        class="btn btn-sm btn-success mt-2">
                        Save
                    </button>

                </div>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-success mt-2">Save All for {{ $student->name }}</button>
</form>
