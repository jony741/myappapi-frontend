<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         id int [pk]
//          email varchar
//          password varchar
//          type int
//          active int
//          created_at timestamp
//          updated_at timestamp
//          email_verified_at timestamp
//          remember_token varchar
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type', ['client', 'business']);
            $table->boolean('active')->default(false);
            $table->string('activation_token');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    //DB Design: https://dbdiagram.io/home
    // Enum table_id {
    //     categories
    //     occasions
    //     events
    //     images
    //     services
    //    }
       
    //   Enum status {
    //     pending
    //     processing
    //     declined
    //     done
    //     cancelled
    //   }
      
    //   Enum promotion_type {
    //   providers_main_page
    //   offeres_main_page
    //   providers_suppliers_page
    //   }
       
    //   Table categories {
    //     id int [pk]
    //     title varchar
    //     image longtext
    //   }
      
    //   Table providers_cat{
    //     id int [pk]
    //     provider_id int [ref: > providers.id]
    //     cat_id int [ref: > categories.id]
    //   }
      
    //   Table occasions {
    //     id int [pk]
    //     title varchar
    //     image longtext
    //   }
      
    //   Table planner_option {
    //     id int [pk]
    //     title varchar
    //   }
      
    //    Table events {
    //     id int [pk]
    //     title varchar
    //     occ_id int [ref: > occasions.id]
    //     budget bigint
    //     planner_option int [ref: > planner_option.id]
    //     event_start datetime
    //     event_end datetime
    //   }
      
    //    Table service_images {
    //     id int [pk]
    //     service_id int [ref: > services.id]
    //     image longtext
    //   }
      
    //    Table locations {
    //     id int [pk]
    //     lat float
    //     lng float
    //     full_address varchar
    //     street_name varchar
    //     building_no varchar
    //   }
      
    //   Table providers {
    //     id int [ref: - users.id]
    //     occ_id int [ref: > occasions.id]
    //     title varchar
    //     full_name varchar
    //     description varchar
    //     phone_number varchar
    //     thumbnail longtext
    //     header longtext
    //     capacity int
    //     location_id int [ref: - locations.id]
    //     accepted bool
    //   }
      
    //    Table orders {
    //     id int [pk]
    //     provider_id int [ref: > providers.id]
    //     client_id int [ref: > users.id]
    //     event_id int [ref: > events.id]
    //     description longtext
    //     status varchar [note: "from status Enum"]
    //     created_at timestamp
    //     updated_at timestamp
    //     status_changed_at timestamp
    //   }
      
    //    Table reviews {
    //     id int [pk]
    //     provider_id int [ref: > providers.id]
    //     user_id int [ref: > users.id]
    //     rate float
    //     title varchar
    //     description longtext
    //     created_at timestamp
    //     updated_at timestamp
    //   }
      
    //   Table orders_services{
    //     id int [pk]
    //     order_id int [ref: > orders.id]
    //     service_id int [ref: > services.id]
    //   }
      
    //    Table services {
    //     id int [pk]
    //     provider_id int [ref: > providers.id]
    //     title varchar
    //     description longtext
    //     price double
    //   }
      
    //   Table translations {
    //     fk int [pk]
    //     lng_id int [pk]
    //     table_id int [pk]
    //     title varchar
    //     description longtext
    //   }
      
    //   Table providers_availability_old{
    //     id int [pk]
    //     provider_id int [ref: - providers.id]
    //     capacity int
    //     all_days_on bool
    //     days_off varchar
    //     all_times_on bool
    //     open_time time
    //     close_time time
    //   }
      
    //   Table providers_availability{
    //     id int [pk]
    //     provider_id int [ref: > providers.id]
    //     weekday int
    //     start_datetime datetime
    //     end_datetime datetime
    //   }
      
      
    //   Table promo_providers{
    //     id int [pk]
    //     provider_id int [ref: > providers.id]
    //     promotion_id int [ref: > promotions.id]
    //     payment_method varchar
    //     expirey_date datetime
    //   }
      
    //   Table promotions{
    //     id int [pk]
    //     promotion_type varchar
    //     title varchar
    //     description longtext
    //     price float
    //   }
      
    //   Table users {
    //     id int [pk]
    //     email varchar
    //     password varchar
    //     type int
    //     active int
    //     created_at timestamp
    //     updated_at timestamp
    //     email_verified_at timestamp
    //     remember_token varchar
    //   }
      
}
