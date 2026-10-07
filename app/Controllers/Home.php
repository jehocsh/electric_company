<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CustomerAccountModel;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'PowerFlow Electric - Reliable Energy Solutions',
            'page'  => 'home'
        ];

        return view('home', $data);
    }

    public function login()
    {
        if (session()->get('isLogged') === true) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            // We keep 'username' here because your HTML <input> is named "username"
            $rules = [
                'username' => 'required|max_length[100]',
                'password' => 'required|max_length[255]',
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', 'Enter both your email and password.');
            }

            $credentials = $this->request->getPost(['username', 'password']);
            
            // FIX: Query the 'email' column instead of 'username'
            $user = (new UserModel())->where('email', $credentials['username'])->first();

            $validPassword = $user !== null
                && (password_verify($credentials['password'], $user['password'])
                    || hash_equals((string) $user['password'], (string) $credentials['password']));

            if (! $validPassword) {
                return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
            }

            session()->regenerate();
            
            // FIX: Use 'first_name' from your DB to set the username session variable
            session()->set([
                'isLogged' => true,
                'user_id'  => $user['id'],
                'username' => $user['first_name'], 
            ]);

            return redirect()->to('/dashboard');
        }

        return view('login');
    }

    public function dashboard()
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $customerModel = new CustomerAccountModel();
        
        $keyword = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        $perPage = 10;

        if ($keyword) {
            $accounts = $customerModel->searchAccounts($keyword, $perPage);
        } elseif ($status) {
            $accounts = $customerModel->getAccountsByStatus($status, $perPage);
        } elseif ($type) {
            $accounts = $customerModel->getAccountsByType($type, $perPage);
        } else {
            $accounts = $customerModel->getAccountsPaginated($perPage);
        }

        $data = [
            'username'           => session()->get('username'),
            'accounts'           => $accounts,
            'pager'              => $customerModel->pager,
            'total_accounts'     => $customerModel->getTotalAccounts(),
            'active_accounts'    => $customerModel->getCountByStatus('active'),
            'inactive_accounts'  => $customerModel->getCountByStatus('inactive'),
            'suspended_accounts' => $customerModel->getCountByStatus('suspended'),
            'current_page'       => $this->request->getGet('page') ?? 1,
            'search_keyword'     => $keyword,
            'filter_status'      => $status,
            'filter_type'        => $type
        ];

        return view('dashboard', $data);
    }

    public function viewAccount($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $customerModel = new CustomerAccountModel();
        $account = $customerModel->find($id);

        if (!$account) {
            return redirect()->to('/dashboard')->with('error', 'Account not found');
        }

        return view('view_account', ['account' => $account]);
    }

public function createAccount()
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        return view('create_account');
    }

    public function storeAccount()
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $customerModel = new CustomerAccountModel();
        
        $data = [
            'account_number'  => $this->request->getPost('account_number'),
            'customer_name'   => $this->request->getPost('customer_name'),
            'address'         => $this->request->getPost('address'),
            'phone'           => $this->request->getPost('phone'),
            'email'           => $this->request->getPost('email'),
            'meter_number'    => $this->request->getPost('meter_number'),
            'connection_type' => $this->request->getPost('connection_type'),
            'status'          => $this->request->getPost('status'),
        ];

        $customerModel->insert($data);
        return redirect()->to('/dashboard')->with('success', 'Customer account created successfully!');
    }

    public function editAccount($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $customerModel = new CustomerAccountModel();
        $account = $customerModel->find($id);

        if (!$account) {
            return redirect()->to('/dashboard')->with('error', 'Account not found');
        }

        return view('edit_account', ['account' => $account]);
    }

    public function updateAccount($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $customerModel = new CustomerAccountModel();
        
        $data = [
            'account_number'  => $this->request->getPost('account_number'),
            'customer_name'   => $this->request->getPost('customer_name'),
            'address'         => $this->request->getPost('address'),
            'phone'           => $this->request->getPost('phone'),
            'email'           => $this->request->getPost('email'),
            'meter_number'    => $this->request->getPost('meter_number'),
            'connection_type' => $this->request->getPost('connection_type'),
            'status'          => $this->request->getPost('status'),
        ];

        $customerModel->update($id, $data);
        return redirect()->to('/dashboard')->with('success', 'Customer account updated successfully!');
    }

    public function deleteAccount($id)
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        $customerModel = new CustomerAccountModel();
        $customerModel->delete($id);

        return redirect()->to('/dashboard')->with('success', 'Customer account deleted successfully!');
    }

    public function logout()
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}