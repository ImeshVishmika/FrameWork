<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f9fa;
            color: #212529;
        }

        .error-container {
            width: 90%;
            max-width: 600px;
            text-align: center;
        }

        .error-code {
            font-size: clamp(100px, 20vw, 180px);
            font-weight: 800;
            line-height: 1;
            color: #212529;
            letter-spacing: -8px;
        }

        .error-title {
            margin-top: 20px;
            font-size: 28px;
            font-weight: 600;
        }

        .error-message {
            margin: 12px auto 30px;
            max-width: 450px;
            color: #6c757d;
            font-size: 16px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .btn-primary {
            background: #212529;
            color: #ffffff;
        }

        .btn-secondary {
            border: 1px solid #dee2e6;
            color: #212529;
            background: #ffffff;
        }

        .brand {
            margin-bottom: 35px;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        @media (max-width: 480px) {
            .error-title {
                font-size: 24px;
            }

            .error-message {
                font-size: 15px;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 180px;
            }
        }
    </style>
</head>

<body>

    <main class="error-container">

        <div class="brand">
            
        </div>

        <div class="error-code">
            403
        </div>

        <h1 class="error-title">
            Access forbidden
        </h1>

        <p class="error-message">
            You don't have permission to access this page.
            Please make sure you're signed in with an account that has the required permissions.
        </p>

        <div class="actions">
            <a href="/" class="btn btn-primary">
                Back to Home
            </a>

            <a href="javascript:history.back()" class="btn btn-secondary">
                Go Back
            </a>
        </div>

    </main>

</body>
</html>

