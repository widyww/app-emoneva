# Sequence Diagram - Login dan Autentikasi

## Alur Login dengan Role-Based Redirect

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant AuthController
    participant Middleware
    participant Database

    User->>Browser: Akses halaman login
    Browser->>AuthController: GET /login
    AuthController->>Browser: Tampilkan form login
    
    User->>Browser: Input email & password
    Browser->>AuthController: POST /login
    AuthController->>Database: Cek kredensial
    Database-->>AuthController: Return user data
    
    alt Kredensial Valid
        AuthController->>AuthController: Create session
        AuthController->>Middleware: Check user role
        
        alt Role = 1 (Administrator)
            Middleware-->>Browser: Redirect /dashboard
        else Role = 2 (Verifikator)
            Middleware-->>Browser: Redirect /dashboard-verifikator
        else Role = 3 (Operator)
            Middleware-->>Browser: Redirect /dashboard-operator
        else Role = 4 (Kabalai)
            Middleware-->>Browser: Redirect /kabalai-dashboard
        end
    else Kredensial Invalid
        AuthController-->>Browser: Return error message
        Browser-->>User: Tampilkan pesan error
    end
```

## Penjelasan Alur

1. **Request Login Page**: User mengakses halaman login
2. **Submit Credentials**: User input email dan password
3. **Validasi**: System cek kredensial di database
4. **Create Session**: Jika valid, buat session untuk user
5. **Role Check**: Middleware memeriksa role user
6. **Redirect**: Redirect ke dashboard sesuai role

## Role dan Dashboard

| Role | Kode | Dashboard URL |
|------|------|---------------|
| Administrator | 1 | /dashboard |
| Verifikator | 2 | /dashboard-verifikator |
| Operator Sekolah | 3 | /dashboard-operator |
| Kepala Balai | 4 | /kabalai-dashboard |

## Kredensial Default Operator

- **Email**: NPSN sekolah
- **Password**: NPSN sekolah
- **Role**: 3 (Operator Sekolah)

## Test Online

Copy code di atas dan paste ke: https://mermaid.live
