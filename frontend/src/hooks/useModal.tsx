import { useCallback, useEffect, useMemo, useState } from "react"
import Modal, { ModalProps } from "../components/Modal"

const useModal = () => {

  const [ isOpen, setIsOpen ] = useState( false )

  const open = () => setIsOpen( true )
  const close = () => setIsOpen( false )

  const Component = useMemo( () => ( props:ModalProps ) => {
    const realProps:ModalProps = {
      isOpen,
      ...props,
      onClose: () => {
        props.onClose && props.onClose()
        close()
      }
    }
    return (
      <Modal { ...realProps } />
    )
  }, [ isOpen ] )

  return {
    Component,
    open,
    close
  }
}

export default useModal