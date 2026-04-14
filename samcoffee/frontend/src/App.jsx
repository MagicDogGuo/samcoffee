import { BrowserRouter, Routes, Route } from 'react-router-dom'
import './App.css'
import Navbar from './components/Navbar.jsx'
import Home from './pages/Home.jsx'
import MenuPage from './pages/MenuPage.jsx'
import OrderHistoryPage from './pages/OrderHistoryPage.jsx'

export default function App() {
  return (
    <BrowserRouter>
      <div className="min-h-screen bg-coffee-cream font-body flex flex-col">
        <Navbar />
        <div className="flex-1">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/menu" element={<MenuPage />} />
            <Route path="/orders" element={<OrderHistoryPage />} />
          </Routes>
        </div>
        <footer className="text-center py-8 bg-coffee-dark text-white">
          <p>&copy; 2025, Sam Kuo, Inc. All rights reserved.</p>
        </footer>
      </div>
    </BrowserRouter>
  )
}
