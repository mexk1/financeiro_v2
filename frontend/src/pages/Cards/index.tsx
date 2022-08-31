import { useCallback, useEffect, useState } from "react"
import DefaultLoader from "../../components/DefaultLoader"
import Modal from "../../components/Modal"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import CardCardComponent from "../../Domains/Cards/CardCardComponent"
import CardForm from "../../Domains/Cards/CardForm"
import useModalControls from "../../hooks/useModalControls"
import useApi from "../../services/api/hooks/useApi"
import { Card } from "../../types/Card"

const Cards = () => {

  const api = useApi()
  const account = useShouldHaveAccountSelected()

  const [selectedCard, setSelectedCard] = useState<Card>()

  const [loading, setLoading] = useState(false)
  const [card, setCard] = useState<Card[]>([])

  const { open, close, isOpen } = useModalControls()

  const load = useCallback(async () => {
    setCard([])
    setLoading(true)
    account && await api.get( `accounts/${account.id}/cards`)
      .then(res => res.data)
      .then(setCard)
      .catch(console.log)
    setLoading(false)
  }, [api])

  const handleUpdate = () => {
    setSelectedCard(undefined)
    close()
    load()
  }

  const selectForUpdate = (a: Card) => {
    setSelectedCard(undefined)
    close()
    setTimeout(() => {
      open()
      setSelectedCard(a)
    }, 100)
  }

  const Form = useCallback(() => (
    <CardForm
      onSuccess={handleUpdate}
      card={selectedCard}
    />
  ), [selectedCard])

  useEffect(() => {
    load()
  }, [load])

  return (
    <div className="flex flex-col h-full justify-start items-center gap-4 p-8 w-full" >
      {
        loading &&
        <div className="w-full h-full flex items-center">
          <DefaultLoader />
        </div>
      }
      {
        card.map(bankAccount => (
          <CardCardComponent
            key={bankAccount.id}
            card={bankAccount}
            onClick={selectForUpdate}
          />
        ))
      }
      <div className="text-black">
        <Modal
          trigger={props => (<>
            {
              !loading &&
              <button
                {...props}
                className={"text-white" + (props?.className ?? '')}
                onClick={e => {
                  setSelectedCard(undefined)
                  props?.onClick && props.onClick(e)
                }
                }
              >
                Adicionar novo
              </button>
            }
          </>
          )}
          isOpen={isOpen}
          onOpen={open}
          onClose={close}
          children={<Form />}
        />
      </div>
    </div>

  )

}

export default Cards