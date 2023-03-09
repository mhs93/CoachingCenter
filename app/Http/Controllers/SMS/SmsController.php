<?php

namespace App\Http\Controllers\SMS;

use App\Models\Exam;
use App\Models\Mark;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Traits\SMSTraits;
use App\Models\Stdpayment;
use App\Models\Tchpayment;
use App\Models\Announcement;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    use SMSTraits;
    public function StdRegistrationMessage($id)
    {
        try {
            $student_info = Student::findOrFail($id);
            $contact      = $student_info->contact_number;
            $email        = $student_info->email;
            $reg_number   = $student_info->reg_no;
            $batch        = $student_info->batch->name;
            $msg          = "Registration Complete, Your Email is:$email, Password:student, Registration number:$reg_number, Batch:$batch";
            $this->sendSms($contact, $msg);

            return redirect()->back()->with('t-success','SMS Sent Successfully');
        } catch (\Exception $exception) {
            $error= $exception->getMessage();
            return redirect()->back()->with('t-error',$error);
        }
    }

    public function StdPayMessage($id){
        try {
            $stdpaym_info = Stdpayment::findOrFail($id);
            $amount = $stdpaym_info->total_amount;
            $month = $stdpaym_info->month;
            $student_info = Student::where('id', $stdpaym_info->std_id)->first();

            $contact=$student_info->contact_number;
            $name=$student_info->name;
            $msg="Monthly fee: $amount tk paid from: $name , Installment month: $month";
            $this->sendSms($contact, $msg);

            return redirect()->back()->with('t-success','SMS Sent Successfully');
        } catch (\Exception $exception) {
            $error= $exception->getMessage();
            return redirect()->back()->with('t-error',$error);
        }
    }

    public function TchRegistrationMessage($id){
        try {
            $teacher_info = Teacher::findOrFail($id);
            $contact=$teacher_info->contact_number;
            $email=$teacher_info->email;
            $reg_number=$teacher_info->reg_no;
            $msg="Registration Complete, Your Email is:$email, Password:student, Registration number:$reg_number";
            $this->sendSms($contact, $msg);

            return redirect()->back()->with('t-success','SMS Sent Successfully');
        } catch (\Exception $exception) {
            $error= $exception->getMessage();
            return redirect()->back()->with('t-error',$error);
        }
    }
    public function TchPayMessage($id){
        try {
            $tchpaym_info = Tchpayment::findOrFail($id);
            $amount = $tchpaym_info->total_amount;
            $month = $tchpaym_info->month;
            $teacher_info = Teacher::where('id', $tchpaym_info->tch_id)->first();
            $contact=$teacher_info->contact_number;
            $name=$teacher_info->name;
            $msg="Monthly salary: $amount tk paid To: $name , Month of the salary: $month";
            $this->sendSms($contact, $msg);
            return redirect()->back()->with('t-success','SMS Sent Successfully');
        } catch (\Exception $exception) {
            $error= $exception->getMessage();
            return redirect()->back()->with('t-error',$error);
        }
    }

    public function ClassRoutineMessage($id){
        try {
            $tchpaym_info = Tchpayment::findOrFail($id);
            $amount = $tchpaym_info->total_amount;
            $month = $tchpaym_info->month;
            $teacher_info = Teacher::where('id', $tchpaym_info->tch_id)->first();
            $contact=$teacher_info->contact_number;
            $name=$teacher_info->name;
            $msg="Monthly salary: $amount tk paid To: $name , Month of the salary: $month";
            $this->sendSms($contact, $msg);
            return redirect()->back()->with('t-success','SMS Sent Successfully');
        } catch (\Exception $exception) {
            $error= $exception->getMessage();
            return redirect()->back()->with('t-error',$error);
        }
    }

    public function AnnouncementMessage($id){
        dd($id);
        try{
            dd('ff');
        }catch (\Exception $exception) {
            $error= $exception->getMessage();
            return redirect()->back()->with('t-error',$error);
        }
    }

    // Student Mark by Batch Send by SMS
    public function markSms($id1, $id2){
        // id1 = ExamId, id2 = BatchId
        try {
            $marks        = Mark::where('batch_id', $id2)
                            ->where('exam_id', $id1)
                            ->orderByRaw('CONVERT(total, SIGNED) desc')
                            ->get();
            $students     = Student::where('batch_id', $id2)->get();
            $batch        = Batch::where('id', $id2)->first();
            $batchName    = $batch->name;
            $exam         = Exam::where('id', $id1)->first();
            $examName     = $exam->name;
            $subjectMarks = '';

            $position = 1;
            foreach ($marks as $mark){
                $subjectIds     = json_decode($batch->subject_id);
                $studentName    = $mark->student->name;
                $studentContact = $mark->student->contact_number;
                $subMark        = json_decode($mark->mark);
                $subjects       = Subject::whereIn('id', $subjectIds)->get();
                $totalMark      = $mark->total;
                foreach ($subjects as $k => $subject){
                    $subjectMarks .= $subject->name. ':' . $subMark[$k]. ', ';
                }
                $subjectMarks = substr($subjectMarks, 0, -2);
                $msg = "Student Name:  $studentName"."\n". "Exam Name: $examName" ."\n". "Batch Name: $batchName" ."\n". "$subjectMarks" ."\n". "Total Mark: $totalMark" ."\n". "Merit Position: $position";
                $this->sendSms($studentContact, $msg);
                $position++;
            }

            return redirect()->back()->with('t-success','SMS Sent Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
