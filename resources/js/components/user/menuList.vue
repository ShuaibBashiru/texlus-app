<template>
<div class="">
<user_passport :server_record="server_record"> </user_passport>
<div class="row">
<div class="col-md-12">
    <div class="m-1 border p-1 rounded-3">
        <ul class="list-group">
        <li class="list-group-item">
            <div class="row back-design">
                <div class="col-md-5 m-0 p-1 text-center">
                <img :src="userProfilePassport" class="rounded-circle" height="110" width="110" alt="Passport">
                </div>
                <div class="col-md-7 m-0 p-1">
                    <p class="m-1 p-1 mt-4 pt-4 mb-0"><span v-text="displayName"></span> <br/>
                    <span class="text-muted">ID: <small class="text-muted" v-text="info.personal_id"></small></span>
                    </p>
                </div>
            </div>
            <div class="row">
            <div class="col-12 ps-0">
                <p class="m-1 p-1 mb-0">
                <span class="text-muted"><small class="text-muted" v-text="info.email_one"></small></span>
                </p>
                </div>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'../profile/'+info.generated_id"> Personal Information </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="#passport" role="button" data-bs-toggle="modal" data-bs-target="#UserPassportModal"> Update passport </a>
            <span v-if="passportStatus" class="badge bg-primary rounded-pill"><i class="bi bi-check fs-6"></i></span>
            <span v-else class="badge bg-danger rounded-pill"><i class="bi bi-x fs-6"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'../name/'+info.generated_id">Profile Name </a>
            <span v-if="nameStatus" class="badge bg-primary rounded-pill"><i class="bi bi-check fs-6"></i></span>
            <span v-else class="badge bg-danger rounded-pill"><i class="bi bi-x fs-6"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'../phone/'+info.generated_id"> Phones </a>
            <span v-if="nameStatus" class="badge bg-primary rounded-pill"><i class="bi bi-check fs-6"></i></span>
            <span v-else class="badge bg-danger rounded-pill"><i class="bi bi-x fs-6"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'../dob/'+info.generated_id"> Date of Birth </a>
            <span v-if="dobStatus" class="badge bg-primary rounded-pill"><i class="bi bi-check fs-6"></i></span>
            <span v-else class="badge bg-danger rounded-pill"><i class="bi bi-x fs-6"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'../gender/'+info.generated_id"> Gender </a>
            <span v-if="genderStatus" class="badge bg-primary rounded-pill"><i class="bi bi-check fs-6"></i></span>
            <span v-else class="badge bg-danger rounded-pill"><i class="bi bi-x fs-6"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'../contactaddress/'+info.generated_id"> Contact address</a>
            <span v-if="contactStatus" class="badge bg-primary rounded-pill"><i class="bi bi-check fs-6"></i></span>
            <span v-else class="badge bg-danger rounded-pill"><i class="bi bi-x fs-6"></i></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a :href="'../attachment/'+info.generated_id"> Attachments </a>
            <span v-if="contactStatus" class="badge bg-primary rounded-pill"><i class="bi bi-check fs-6"></i></span>
            <span v-else class="badge bg-danger rounded-pill"><i class="bi bi-x fs-6"></i></span>
        </li>
        </ul>
        </div>
        </div>
    </div>

</div>

</template>

<script>
export default {
    name: 'updateUserSideMenu',
    props: ['server_record'],
    data (){
        return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        usersession: [],
        counter: '0',
        errors: [],
        form_success: [],
        userProfilePassport: '/assets/icons/avatar.png',
        displayName: '',
        nameStatus: false,
        dobStatus: false,
        genderStatus: false,
        contactStatus: false,
        passportStatus: false,
        parameters:{
            lastname: '',
            firstname: '',
            othername: '',
            generated_id: '',
        },
    }
    },

    created(){
        this.getRecords();
        this.getDisplayName();
        this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport;
        this.validateName();
        this.validateDob();
        this.validateGender();
        this.validateContact();
        this.validatePassport();
    },

    methods:{
    getRecords: function(){
        this.parameters.generated_id = this.info.generated_id
        this.parameters.lastname = this.info.lastname
        this.parameters.firstname = this.info.firstname
        this.parameters.othername = this.info.othername
    },

    getDisplayName: function(){
            var character = this.info.firstname.charAt(0);
            var name = this.info.lastname + ' ' + character + '.';
            this.displayName = name;
    },

    validateName: function(){
        if (this.info.lastname && this.info.firstname) {
            this.nameStatus = true;
        }else{
            this.nameStatus = false;
        }
    },

    validatePassport: function(){
        if (this.info.file_url) {
            this.passportStatus = true;
        }else{
            this.passportStatus = false;
        }
    },

    validateDob: function(){
        if (this.info.dob && this.info.mob && this.info.yob) {
            this.dobStatus = true;
        }else{
            this.dobStatus = false;
        }
    },

    validateGender: function(){
        if (this.info.gender_name) {
            this.genderStatus = true;
        }else{
            this.genderStatus = false;
        }
    },

    validateContact: function(){
        if (this.info.country_id && this.info.state_id && this.info.address_one && this.info.phone_code && this.info.phone_one) {
            this.contactStatus = true;
        }else{
            this.contactStatus = false;
        }
    },

    }


    }
</script>