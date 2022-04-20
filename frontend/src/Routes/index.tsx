import { 
  Routes as Wrapper, Route 
} from "react-router-dom"
import Home from "../pages/Home"
import Login from "../pages/Login"

const Routes = () => {

  return (
    <Wrapper>
      <Route path="/login" element={<Login />} />
      <Route index element={<Home />} />
    </Wrapper>
  )
}

export default Routes