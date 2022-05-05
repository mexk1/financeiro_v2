import useUser from "./useUser"

const useIsUserLogged = () => {
  return undefined !== useUser()
}


export default useIsUserLogged