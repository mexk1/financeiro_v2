import { useEffect, useState } from "react"


interface Props {
  defaultOpen?: boolean,
  onClose?: () => void 
  onOpen?: () => void 
}
const useModalControls = ( props?:Props ) => {

  const { onClose, onOpen, defaultOpen } = props ?? {}

  const [ isOpen, setIsOpen ] = useState<boolean|undefined>( defaultOpen )

  const close = () => {
    setIsOpen( false )
    onClose && onClose ()
  }

  const open = () => {
    setIsOpen( true )
    onOpen && onOpen()
  }

  useEffect( () => {
    setIsOpen( defaultOpen )
  }, [ defaultOpen ] )

  return {
    isOpen, 
    open,
    close
  }
}

export default useModalControls