import { useEffect } from "react"
import api from ".."
import useUser from "../../../Domains/User/hooks/useUser"

const useApi = () => {

  const user = useUser()

  useEffect( () => {
    user?.access_token && api.interceptors.request.use( req => {
      req.headers = { 
        ...req.headers,
        'Authorization': `Bearer ${user?.access_token}`
      }
      return req
    }, rej => {
      return rej
    })
  }, [ user ] )

  return api
}
export default useApi