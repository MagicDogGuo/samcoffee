import { NavLink, useNavigate, useLocation } from 'react-router-dom'

export default function Navbar() {
  const navigate = useNavigate()
  const location = useLocation()

  const linkClass = ({ isActive }) =>
    isActive
      ? 'text-coffee-light font-semibold'
      : 'text-gray-600 hover:text-coffee-light font-semibold transition-colors duration-300'

  const scrollToSection = (id) => {
    if (location.pathname === '/') {
      document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })
    } else {
      navigate('/')
      setTimeout(() => {
        document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })
      }, 100)
    }
  }

  return (
    <header className="bg-white shadow-md sticky top-0 z-50">
      <div className="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <div className="font-logo text-3xl text-coffee-medium">Sam's Café</div>
        <nav className="flex gap-6 text-sm">
          <NavLink to="/" end className={linkClass}>Home</NavLink>
          <button
            onClick={() => scrollToSection('about')}
            className="text-gray-600 hover:text-coffee-light font-semibold transition-colors duration-300 cursor-pointer"
          >
            About Us
          </button>
          <button
            onClick={() => scrollToSection('contact')}
            className="text-gray-600 hover:text-coffee-light font-semibold transition-colors duration-300 cursor-pointer"
          >
            Contact Us
          </button>
          <NavLink to="/menu" className={linkClass}>Menu</NavLink>
          <NavLink to="/orders" className={linkClass}>Order History</NavLink>
        </nav>
      </div>
    </header>
  )
}
