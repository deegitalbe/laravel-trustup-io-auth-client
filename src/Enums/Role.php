<?php

namespace Deegitalbe\LaravelTrustupIoAuthClient\Enums;

enum Role: string
{
    case NOVA = "Nova";
    case SUPER_ADMIN = "Super Admin";
    case DEVELOPER = "Developer";
    case APPLICATION_DEVELOPER = "Application Developer";
    case APP_SALESMAN = "App Salesman";
    case STUDENT = "Student";
    case MARKETPLACE_SUPPORT = "Marketplace Support";
    case MARKETPLACE_SALESMAN = "Marketplace Salesman";
    case BAILIFF = "Bailiff";
    case TOOLS_SUPPORT = "Tools Support";
    case TRANSLATOR = "Translator";
    case ERP = "ERP";
    case MARKETING = "Marketing";
    case WEBSITE_MANAGER = "Website Manager";
    case ADMIN_PRO = "Admin Pro";
    case EMPLOYEE = "Employee";
    case HR = "HR";
    case NOTIFIER = "Notifier";
    case OLD_SALESMAN = "Old Salesman";
}
