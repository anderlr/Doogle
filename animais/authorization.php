<?php

include_once dirname(__FILE__) . '/' . 'phpgen_settings.php';
include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/security/permission_set.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_authentication/table_based_user_authentication.php';
include_once dirname(__FILE__) . '/' . 'components/security/grant_manager/hard_coded_user_grant_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/table_based_user_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_identity_storage/user_identity_session_storage.php';
include_once dirname(__FILE__) . '/' . 'components/security/recaptcha.php';
include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

$grants = array('guest' => 
        array()
    ,
    'defaultUser' => 
        array('animal_encontrado' => new PermissionSet(false, false, false, false),
        'animal_encontrado.animal_procurado' => new PermissionSet(false, false, false, false),
        'animal_procurado' => new PermissionSet(false, false, false, false),
        'nivel_acesso' => new PermissionSet(false, false, false, false),
        'nivel_acesso.usuarios' => new PermissionSet(false, false, false, false),
        'usuarios' => new PermissionSet(false, false, false, false),
        'usuarios.animal_encontrado' => new PermissionSet(false, false, false, false))
    ,
    'Douglas' => 
        array('animal_encontrado' => new PermissionSet(false, false, false, false),
        'animal_encontrado.animal_procurado' => new PermissionSet(false, false, false, false),
        'animal_procurado' => new PermissionSet(false, false, false, false),
        'nivel_acesso' => new PermissionSet(false, false, false, false),
        'nivel_acesso.usuarios' => new PermissionSet(false, false, false, false),
        'usuarios' => new PermissionSet(false, false, false, false),
        'usuarios.animal_encontrado' => new PermissionSet(false, false, false, false))
    ,
    'Anderson' => 
        array('animal_encontrado' => new PermissionSet(false, false, false, false),
        'animal_encontrado.animal_procurado' => new PermissionSet(false, false, false, false),
        'animal_procurado' => new PermissionSet(false, false, false, false),
        'nivel_acesso' => new PermissionSet(false, false, false, false),
        'nivel_acesso.usuarios' => new PermissionSet(false, false, false, false),
        'usuarios' => new PermissionSet(false, false, false, false),
        'usuarios.animal_encontrado' => new PermissionSet(false, false, false, false))
    ,
    'Luiz' => 
        array('animal_encontrado' => new PermissionSet(false, false, false, false),
        'animal_encontrado.animal_procurado' => new PermissionSet(false, false, false, false),
        'animal_procurado' => new PermissionSet(false, false, false, false),
        'nivel_acesso' => new PermissionSet(false, false, false, false),
        'nivel_acesso.usuarios' => new PermissionSet(false, false, false, false),
        'usuarios' => new PermissionSet(false, false, false, false),
        'usuarios.animal_encontrado' => new PermissionSet(false, false, false, false))
    );

$appGrants = array('guest' => new PermissionSet(false, false, false, false),
    'defaultUser' => new AdminPermissionSet(),
    'Douglas' => new AdminPermissionSet(),
    'Anderson' => new AdminPermissionSet(),
    'Luiz' => new AdminPermissionSet());

$dataSourceRecordPermissions = array();

$tableCaptions = array('animal_encontrado' => 'Animal Encontrado',
'animal_encontrado.animal_procurado' => 'Animal Encontrado->Animal Procurado',
'animal_procurado' => 'Animal Procurado',
'nivel_acesso' => 'Nivel Acesso',
'nivel_acesso.usuarios' => 'Nivel Acesso->Usuarios',
'usuarios' => 'Usuarios',
'usuarios.animal_encontrado' => 'Usuarios->Animal Encontrado');

$usersTableInfo = array(
    'TableName' => 'usuarios',
    'UserId' => 'id',
    'UserName' => 'nome',
    'Password' => 'senha',
    'Email' => '',
    'UserToken' => '',
    'UserStatus' => ''
);

function EncryptPassword($password, &$result)
{

}

function VerifyPassword($enteredPassword, $encryptedPassword, &$result)
{

}

function BeforeUserRegistration($userName, $email, $password, &$allowRegistration, &$errorMessage)
{

}    

function AfterUserRegistration($userName, $email)
{

}    

function PasswordResetRequest($userName, $email)
{

}

function PasswordResetComplete($userName, $email)
{

}

function VerifyPasswordStrength($password, &$result, &$passwordRuleMessage) 
{

}

function CreatePasswordHasher()
{
    $hasher = CreateHasher('');
    if ($hasher instanceof CustomStringHasher) {
        $hasher->OnEncryptPassword->AddListener('EncryptPassword');
        $hasher->OnVerifyPassword->AddListener('VerifyPassword');
    }
    return $hasher;
}

function CreateGrantManager() 
{
    global $grants;
    global $appGrants;
    
    return new HardCodedUserGrantManager($grants, $appGrants);
}

function CreateTableBasedUserManager() 
{
    global $usersTableInfo;

    $userManager = new TableBasedUserManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(), 
        $usersTableInfo, CreatePasswordHasher(), false);
    $userManager->OnVerifyPasswordStrength->AddListener('VerifyPasswordStrength');

    return $userManager;
}

function GetReCaptcha($formId) 
{
    return null;
}

function SetUpUserAuthorization() 
{
    global $dataSourceRecordPermissions;

    $hasher = CreatePasswordHasher();

    $grantManager = CreateGrantManager();

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage(), false, $hasher, CreateTableBasedUserManager(), true, false, false);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
