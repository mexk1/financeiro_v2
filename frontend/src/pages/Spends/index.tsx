import { useCallback, useEffect, useState } from "react"
import InfiniteScroll from "react-infinite-scroll-component"
import { useNavigate } from "react-router-dom"
import DefaultLoader from "../../components/DefaultLoader"
import Modal from "../../components/Modal"
import PAGES from "../../constants/PAGES"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import SpendForm from "../../Domains/Spends/SpendForm"
import SpendsList from "../../Domains/Spends/SpendsList"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"
import useModalControls from "../../hooks/useModalControls"
import usePagination from "../../hooks/usePagination"
import { Spend } from "../../types/Spend"

const Spends = () => {
  const account = useShouldHaveAccountSelected()
  const navigate = useNavigate()

  const [selectSpend, setSelectedSpend] = useState<Spend>()
  const { open, close, isOpen } = useModalControls()
  const { list, loading, reset, loadMore, end } = usePagination<Spend>(`accounts/${account?.id}/spends`)

  const handleUpdate = () => {
    setSelectedSpend(undefined)
    close()
    reset()
  }

  const selectForUpdate = (s: Spend) => {
    setSelectedSpend(undefined)
    close()
    setTimeout(() => {
      open()
      setSelectedSpend(s)
    }, 100)
  }

  const Form = useCallback(() => (
    <SpendForm
      onSuccess={handleUpdate}
      spend={selectSpend}
    />
  ), [selectSpend])

  return (
    <LoggedTemplate
      title="Spends"
      subTitle={{
        text: account?.name,
        action: () => navigate(PAGES.accountsSelect.path)
      }}
    >
      <div className="flex flex-col h-full justify-start items-center gap-4 p-8 w-full" >
        <div className="text-black">
          <Modal
            trigger={props => (<>
              {
                !loading &&
                <button
                  {...props}
                  className={"text-white" + (props?.className ?? '')}
                  onClick={e => {
                    props?.onClick && props.onClick(e)
                    setSelectedSpend(undefined)
                  }
                  }
                >
                  Adicionar nova
                </button>
              }
            </>
            )}
            isOpen={isOpen}
            onOpen={open}
            onClose={close}
            children={ <Form /> }
          />
        </div>
        <div className="w-full h-full overflow-scroll" id="spends-list">
          <InfiniteScroll
            dataLength={list.length}
            next={ loadMore }
            scrollableTarget="spends-list"
            hasMore={!end}
            loader={
              loading &&
              <div className="w-full h-full flex items-center">
                <DefaultLoader />
              </div>
            }
            // below props only if you need pull down functionality
            refreshFunction={reset}
            pullDownToRefresh
            pullDownToRefreshThreshold={50}
            pullDownToRefreshContent={
              <h3 style={{ textAlign: 'center' }}>&#8595; Pull down to refresh</h3>
            }
            releaseToRefreshContent={
              <h3 style={{ textAlign: 'center' }}>&#8593; Release to refresh</h3>
            }
          >
            <SpendsList
              list={list}
              onClickItem={selectForUpdate}
            />
          </InfiniteScroll>
        </div>
      </div>
    </LoggedTemplate>
  )
}

export default Spends