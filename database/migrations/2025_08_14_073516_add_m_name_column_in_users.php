<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'm_name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('m_name')->after('f_name')->nullable();
                    $table->string('mother_tongue')->nullable();
                    $table->string('primary_communication_lang')->nullable();
                    $table->string('nationality')->nullable();
                    $table->unsignedBigInteger('approve_mail_count')->default(0)->nullable();
                    $table->unsignedBigInteger('suspend_mail_count')->default(0)->nullable();
                });
            }
        }
        
        if (Schema::hasTable('tutorship_plan')) {
            if (!Schema::hasColumn('tutorship_plan', 'branch_id')) {
                Schema::table('tutorship_plan', function (Blueprint $table) {
                    $table->unsignedBigInteger('branch_id')->after('grade_id')->nullable();
                });
            }
        }
        
        if (Schema::hasTable('teacher_academic')) {
            if (!Schema::hasColumn('teacher_academic', 'located_in')) {
                Schema::table('teacher_academic', function (Blueprint $table) {
                    $table->text('located_in')->after('university')->nullable();
                });
            }
        }
        
        if (Schema::hasTable('teacher_experience')) {
            if (!Schema::hasColumn('teacher_experience', 'is_educational_institution')) {
                Schema::table('teacher_experience', function (Blueprint $table) {
                    $table->unsignedBigInteger('is_educational_institution')->comment('1-Yes, 2-No, 3-Default')->default(3)->after('organization')->nullable();
                    $table->text('institution_name')->after('is_educational_institution')->nullable();
                    $table->text('institution_type')->after('institution_name')->nullable();
                });
            }
        }
        
        if (Schema::hasTable('teacher_recognition')) {
            if (!Schema::hasColumn('teacher_recognition', 'location')) {
                Schema::table('teacher_recognition', function (Blueprint $table) {
                    $table->text('location')->after('organization')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'm_name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('m_name');
                    $table->dropColumn('mother_tongue');
                    $table->dropColumn('primary_communication_lang');
                    $table->dropColumn('nationality');
                    $table->dropColumn('approve_mail_count');
                    $table->dropColumn('suspend_mail_count');
                });
            }
        }
        
        if (Schema::hasTable('tutorship_plan')) {
            if (Schema::hasColumn('tutorship_plan', 'branch_id')) {
                Schema::table('tutorship_plan', function (Blueprint $table) {
                    $table->dropColumn('branch_id');
                });
            }
        }
        
        if (Schema::hasTable('teacher_academic')) {
            if (Schema::hasColumn('teacher_academic', 'located_in')) {
                Schema::table('teacher_academic', function (Blueprint $table) {
                    $table->dropColumn('located_in');
                });
            }
        }
        
        if (Schema::hasTable('teacher_experience')) {
            if (Schema::hasColumn('teacher_experience', 'is_educational_institution')) {
                Schema::table('teacher_experience', function (Blueprint $table) {
                    $table->dropColumn('is_educational_institution');
                    $table->dropColumn('institution_name');
                    $table->dropColumn('institution_type');
                });
            }
        }
        
        if (Schema::hasTable('teacher_recognition')) {
            if (Schema::hasColumn('teacher_recognition', 'location')) {
                Schema::table('teacher_recognition', function (Blueprint $table) {
                    $table->dropColumn('location');
                });
            }
        }
    }
};
