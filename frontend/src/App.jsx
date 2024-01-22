import HomePage from "./pages/HomePage";
import LoginPage from "./pages/LoginPage";
import RegisterPage from "./pages/RegisterPage";
import MyAccountPage from "./pages/MyAccountPage";
import AboutPage from "./pages/AboutPage";
import LogPage from "./pages/LogPage";
import LocalStorage from "./helpers/LocalStorage";
import { Navigate, useLocation } from 'react-router-dom';

import { BrowserRouter, Route, Routes } from "react-router-dom";

import axios from 'axios';

axios.defaults.baseURL = 'https://ccscore.it-core.fun/';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';
axios.defaults.withCredentials = true;

function ProtectedComponent({ children }) {
    const location = useLocation();
    const isLoggedIn = LocalStorage.IsUserLogged();

    return isLoggedIn ? children : <Navigate to="/login" state={{ from: location }} />;
}

function App() {
    return (
        <div>
            <BrowserRouter>
                <Routes>
                    <Route path="/" element={<ProtectedComponent><HomePage /></ProtectedComponent>} />
                    <Route path="/home" element={<ProtectedComponent><HomePage /></ProtectedComponent>} />
                    <Route path="/login" element={<LoginPage />} />
                    <Route path="/register" element={<RegisterPage />} />
                    <Route path="/account" element={<ProtectedComponent><MyAccountPage /></ProtectedComponent>} />
                    <Route path="/about" element={<ProtectedComponent><AboutPage /></ProtectedComponent>} />
                    <Route path="/logs" element={<ProtectedComponent><LogPage /></ProtectedComponent>} />
                </Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;